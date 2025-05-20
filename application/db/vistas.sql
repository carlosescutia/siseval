/*
Vista totales_calificaciones
-----------------------
Se obtiene suma y conteo de criterios de calificación de propuesta
*/
DROP VIEW IF EXISTS totales_calificacion CASCADE;
CREATE VIEW totales_calificacion AS
SELECT
    cp.id_calificacion_propuesta,
    (
        (case when 'agenda2030' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.agenda2030 >= 0 then cp.agenda2030 else 0 end) +
        (case when 'pertinencia_evaluacion' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.pertinencia_evaluacion >= 0 then cp.pertinencia_evaluacion else 0 end) +
        (case when 'ciclo_evaluativo' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.ciclo_evaluativo >= 0 then cp.ciclo_evaluativo else 0 end) +
        (case when 'recomendaciones_previas' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.recomendaciones_previas >= 0 then cp.recomendaciones_previas else 0 end) +
        (case when 'informacion_disponible' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.informacion_disponible >= 0 then cp.informacion_disponible else 0 end)
    ) as suma,
    (
        (case when 'agenda2030' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.agenda2030 >= 0 then 1 else 0 end) +
        (case when 'pertinencia_evaluacion' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.pertinencia_evaluacion >= 0 then 1 else 0 end) +
        (case when 'ciclo_evaluativo' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.ciclo_evaluativo >= 0 then 1 else 0 end) +
        (case when 'recomendaciones_previas' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.recomendaciones_previas >= 0 then 1 else 0 end) +
        (case when 'informacion_disponible' in (select ccp.nom_criterio from criterios_calificacion_periodo ccp where ccp.periodo = p.periodo) and cp.informacion_disponible >= 0 then 1 else 0 end)
    ) as conteo
FROM 
    calificaciones_propuesta cp
    left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = cp.id_propuesta_evaluacion
    left join proyectos p on p.id_proyecto = pe.id_proyecto ;

/*
Vista puntaje_calificacion_dependencia
-----------------------
Se obtiene puntaje de dependencia de calificación de propuesta
 */
DROP VIEW IF EXISTS puntaje_calificacion_dependencia CASCADE;
CREATE VIEW puntaje_calificacion_dependencia AS
SELECT 
    cp.id_calificacion_propuesta, cp.cve_dependencia, d.nom_dependencia, 
    pe.id_proyecto, cp.id_propuesta_evaluacion, pe.id_tipo_evaluacion, te.nom_tipo_evaluacion, 
    (case 
        when cp.evaluacion_obligatoria = 1 then 100
        when conteo = 0 then 0
        else suma / conteo 
    end) + coalesce(cp.criterio_institucional, 0) as puntaje,
    py.periodo
FROM 
    calificaciones_propuesta cp
    left join totales_calificacion tc on cp.id_calificacion_propuesta = tc.id_calificacion_propuesta
    left join propuestas_evaluacion pe on cp.id_propuesta_evaluacion = pe.id_propuesta_evaluacion
    left join proyectos py on py.id_proyecto = pe.id_proyecto
    left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion 
    left join get_dependencia_periodo(cp.cve_dependencia, py.periodo) d on cp.cve_dependencia = d.cve_dependencia;
/*
Vista puntaje_calificacion_propuesta
-----------------------
Se obtiene puntaje,conteo,probabilidad y status de calificaciones de propuestas
 */
DROP VIEW IF EXISTS puntaje_calificacion_propuesta CASCADE;
CREATE VIEW puntaje_calificacion_propuesta AS
select
    pe.id_proyecto, d.cve_dependencia, d.nom_dependencia, pe.id_propuesta_evaluacion, pe.id_tipo_evaluacion, te.nom_tipo_evaluacion,
    sum(pcd.puntaje) as puntaje, count(pcd.id_propuesta_evaluacion) as num_calificaciones,
    (case
        when pe.id_tipo_evaluacion in (select id_tipo_evaluacion from tipos_evaluacion_periodo where periodo = py.periodo) then 'Por normativa'
        else (select nom_probabilidad_inclusion from probabilidades_inclusion where sum(pcd.puntaje) between min and max and periodo = py.periodo)
    end
    ) as probabilidad,
    (case 
        when pe.id_tipo_evaluacion in (select id_tipo_evaluacion from tipos_evaluacion_periodo where periodo = py.periodo) then 'totalmente_calificada'
        when coalesce(count(pcd.id_propuesta_evaluacion), 0) = 0 then 'no_calificada'
        when count(pcd.id_propuesta_evaluacion) < (select num_supervisores from periodos where nom_periodo = py.periodo) then 'parcialmente_calificada'
        when count(pcd.id_propuesta_evaluacion) = (select num_supervisores from periodos where nom_periodo = py.periodo) then 'totalmente_calificada'
    end
    ) as status_calificacion
from
    propuestas_evaluacion pe
    left join proyectos py on py.id_proyecto = pe.id_proyecto
    left join get_dependencia_periodo(pe.cve_dependencia, py.periodo) d on pe.cve_dependencia = d.cve_dependencia
    left join tipos_evaluacion te on te.id_tipo_evaluacion = pe.id_tipo_evaluacion
    left join puntaje_calificacion_dependencia pcd on pcd.id_propuesta_evaluacion = pe.id_propuesta_evaluacion
group by
    pe.id_proyecto, d.cve_dependencia, d.nom_dependencia, pe.id_propuesta_evaluacion, pe.id_tipo_evaluacion, te.nom_tipo_evaluacion, py.periodo
;


/*
Vista estadisticas_dependencia
-----------------------
Se obtienen estadisticas por dependencia
 */
DROP VIEW IF EXISTS estadisticas_dependencia CASCADE;
CREATE VIEW estadisticas_dependencia AS
SELECT 
    py.cve_dependencia,
    py.periodo,
    count(py.id_proyecto) as num_proyectos,
    (select count(*) from propuestas_evaluacion pe left join proyectos proy on pe.id_proyecto = proy.id_proyecto where proy.cve_dependencia = py.cve_dependencia and proy.periodo = py.periodo) as num_proyectos_propuesta,
    (select count(*) from propuestas_evaluacion pe left join proyectos proy on pe.id_proyecto = proy.id_proyecto where pe.id_propuesta_evaluacion in (select id_propuesta_evaluacion from calificaciones_propuesta) and proy.cve_dependencia = py.cve_dependencia and proy.periodo = py.periodo) as num_propuestas_calificadas
FROM 
    proyectos py  
GROUP BY
    py.cve_dependencia, py.periodo ;
