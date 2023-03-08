/*
Vista puntaje_calificacion_dependencia
-----------------------
Se obtiene puntaje de dependencia de calificación de propuesta
 */
DROP VIEW IF EXISTS puntaje_calificacion_dependencia CASCADE;
CREATE VIEW puntaje_calificacion_dependencia AS
SELECT
    cp.id_calificacion_propuesta, cp.cve_dependencia, d.nom_dependencia,
    pe.cve_proyecto, cp.id_propuesta_evaluacion, te.nom_tipo_evaluacion,
    (case when cp.evaluacion_obligatoria = 1 then 100
    else (
        (case when cp.agenda2030 >= 0 then cp.agenda2030 else 0 end)
        + (case when cp.pertinencia_evaluacion >= 0 then cp.pertinencia_evaluacion else 0 end)
        + (case when cp.ciclo_evaluativo >= 0 then cp.ciclo_evaluativo else 0 end)
        + (case when cp.recomendaciones_previas >= 0 then cp.recomendaciones_previas else 0 end)
        + (case when cp.informacion_disponible >= 0 then cp.informacion_disponible else 0 end)
    ) / (
        (case when cp.agenda2030 >= 0 then 1 else 0 end)
        + (case when cp.pertinencia_evaluacion >= 0 then 1 else 0 end)
        + (case when cp.ciclo_evaluativo >= 0 then 1 else 0 end)
        + (case when cp.recomendaciones_previas >= 0 then 1 else 0 end)
        + (case when cp.informacion_disponible >= 0 then 1 else 0 end)
    ) end) + cp.criterio_institucional as puntaje
FROM
    calificaciones_propuesta cp
    left join propuestas_evaluacion pe on cp.id_propuesta_evaluacion = pe.id_propuesta_evaluacion
    left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion
    left join dependencias d on cp.cve_dependencia = d.cve_dependencia;

/*
Vista puntaje_calificacion_propuesta
-----------------------
Se obtiene puntaje de calificaciones de propuestas
 */
DROP VIEW IF EXISTS puntaje_calificacion_propuesta CASCADE;
CREATE VIEW puntaje_calificacion_propuesta AS
SELECT 
    pcd.cve_proyecto, pcd.id_propuesta_evaluacion, pcd.nom_tipo_evaluacion, 
    sum(pcd.puntaje) as puntaje,
    (select nom_probabilidad_inclusion from probabilidades_inclusion where sum(pcd.puntaje) between min and max) as probabilidad
FROM 
    puntaje_calificacion_dependencia pcd
GROUP BY 
    pcd.cve_proyecto, pcd.id_propuesta_evaluacion, pcd.nom_tipo_evaluacion ;


/*
Vista estadisticas_dependencia
-----------------------
Se obtienen estadisticas por dependencia
 */
DROP VIEW IF EXISTS estadisticas_dependencia CASCADE;
CREATE VIEW estadisticas_dependencia AS
SELECT 
    py.cve_dependencia,
    count(py.cve_proyecto) as num_proyectos,
    (select count(*) from propuestas_evaluacion pe left join proyectos proy on pe.cve_proyecto = proy.cve_proyecto where proy.cve_dependencia = py.cve_dependencia) as num_proyectos_propuesta,
    (select count(*) from propuestas_evaluacion pe left join proyectos proy on pe.cve_proyecto = proy.cve_proyecto where pe.id_propuesta_evaluacion in (select id_propuesta_evaluacion from calificaciones_propuesta) and proy.cve_dependencia = py.cve_dependencia) as num_propuestas_calificadas
FROM 
    proyectos py  
GROUP BY
    py.cve_dependencia ;
