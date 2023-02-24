/* Eliminar vistas para permitir eliminar tablas dependientes */
DROP VIEW IF EXISTS puntaje_calificacion_propuesta;
DROP VIEW IF EXISTS puntaje_calificacion_dependencia;
DROP VIEW IF EXISTS estadisticas_dependencia;

/* Tablas de información del sistema */

DROP TABLE IF EXISTS proyectos;
CREATE TABLE proyectos (
    id_proyecto serial,
    cve_proyecto text,
    cve_anterior_proyecto text,
    nom_proyecto text,
    cve_programa text,
    periodo integer,
    presupuesto_aprobado numeric (12,2),
    cve_tipo_gasto text,
    anexo_social integer
);

DROP TABLE IF EXISTS programas;
CREATE TABLE programas (
    id_programa serial,
    cve_programa text,
    nom_programa text,
    cve_dependencia integer
);

DROP TABLE IF EXISTS evaluaciones;
CREATE TABLE evaluaciones (
    id_evaluacion serial,
    cve_proyecto text,
    periodo text,
    tipo_evaluacion text,
    metodo_financiamiento text,
    nom_evaluador text,
    costo_total_evaluacion numeric(12,2),
    dependencia_responsable text,
    liga_general_informe_evaluacion text,
    liga_directa_informe_evaluacion text,
    liga_conag text
);

DROP TABLE IF EXISTS propuestas_evaluacion;
CREATE TABLE propuestas_evaluacion (
    id_propuesta_evaluacion serial,
    cve_proyecto text,
    cve_dependencia integer,
    id_tipo_evaluacion integer,
    otro_tipo_evaluacion text,
    id_justificacion_evaluacion integer,
    otra_justificacion_evaluacion text,
    objetivo text,
    recursos_propios text,
    monto numeric(12,2),
    recomendaciones_previas integer,
    observaciones text
);

DROP TABLE IF EXISTS tipos_evaluacion;
CREATE TABLE tipos_evaluacion (
    id_tipo_evaluacion serial,
    nom_tipo_evaluacion text
);

DROP TABLE IF EXISTS justificaciones_evaluacion;
CREATE TABLE justificaciones_evaluacion (
    id_justificacion_evaluacion serial,
    nom_justificacion_evaluacion text
);

DROP TABLE IF EXISTS calificaciones_propuesta;
CREATE TABLE calificaciones_propuesta (
    id_calificacion_propuesta serial,
    id_propuesta_evaluacion integer,
    cve_dependencia integer,
    evaluacion_obligatoria integer,
    agenda2030 integer,
    pertinencia_evaluacion integer,
    ciclo_evaluativo integer,
    recomendaciones_previas integer,
    justificacion_no_atencion text,
    informacion_disponible integer,
    clasificacion_supervisor integer,
    comentarios text
);

DROP TABLE IF EXISTS valores_calificacion;
CREATE TABLE valores_calificacion (
    id_valor_calificacion serial,
    puntaje integer,
    nom_valor_calificacion text
);

DROP TABLE IF EXISTS clasificaciones_supervisor;
CREATE TABLE clasificaciones_supervisor (
    id_clasificacion_supervisor serial,
    cve_clasificacion_supervisor integer,
    nom_clasificacion_supervisor text
);

DROP TABLE IF EXISTS probabilidades_inclusion;
CREATE TABLE probabilidades_inclusion (
    id_probabilidad_inclusion serial,
    min integer,
    max integer,
    nom_probabilidad_inclusion text
);

DROP TABLE IF EXISTS objetivos_desarrollo;
CREATE TABLE objetivos_desarrollo (
    id_objetivo_desarrollo serial,
    cve_objetivo_desarrollo integer,
    nom_objetivo_desarrollo text
);

DROP TABLE IF EXISTS metas_ods;
CREATE TABLE metas_ods (
    id_meta_ods serial,
    cve_meta_ods text,
    cve_objetivo_desarrollo integer,
    nom_meta_ods text
);

DROP TABLE IF EXISTS programas_metas;
CREATE TABLE programas_metas (
    id_programa_meta serial,
    cve_programa text,
    cve_meta_ods text
);



/* Tablas de administración del sistema */

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    cve_usuario serial, 
    cve_dependencia integer,
    cve_rol text,
    nom_usuario text,
    usuario text,
    password text,
    activo integer
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    cve_rol text,
    nom_rol text
);

DROP TABLE IF EXISTS opciones_sistema;
CREATE TABLE opciones_sistema (
    cve_opcion serial,
    cod_opcion text,
    nom_opcion text,
    url text,
    es_menu integer
);

DROP TABLE IF EXISTS accesos_sistema;
CREATE TABLE accesos_sistema (
    cve_acceso serial,
    cve_rol text,
    cod_opcion text
);

DROP TABLE IF EXISTS dependencias;
CREATE TABLE dependencias (
    cve_dependencia serial,
    nom_dependencia text,
    nom_completo_dependencia text,
    carga_evaluaciones integer
);

DROP TABLE IF EXISTS bitacora;
CREATE TABLE bitacora (
    cve_evento serial,
    fecha date,
    hora time,
    origen text,
    usuario text,
    nom_usuario text,
    nom_dependencia text,
    accion text,
    entidad text,
    valor text
);

DROP TABLE IF EXISTS parametros_sistema;
CREATE TABLE parametros_sistema (
    cve_parametro_sistema serial,
    nom_parametro_sistema text,
    valor_parametro_sistema text
);

/* Vistas para reportes */

/*
Vista puntaje_calificacion_dependencia
-----------------------
Se obtiene puntaje de dependencia de calificación de propuesta
 */
CREATE VIEW puntaje_calificacion_dependencia AS
SELECT 
    cp.id_calificacion_propuesta, cp.cve_dependencia, d.nom_dependencia, pe.cve_proyecto, cp.id_propuesta_evaluacion, te.nom_tipo_evaluacion,
    (case
        when evaluacion_obligatoria = 1 then 500
        else (agenda2030 + pertinencia_evaluacion + ciclo_evaluativo + cp.recomendaciones_previas + informacion_disponible)
    end) / 5 as puntaje
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
CREATE VIEW estadisticas_dependencia AS
SELECT 
    pg.cve_dependencia,
    count(py.cve_proyecto) as num_proyectos,
    (select count(*) from propuestas_evaluacion pe left join proyectos py on pe.cve_proyecto = py.cve_proyecto left join programas p on py.cve_programa = p.cve_programa where p.cve_dependencia = pg.cve_dependencia) as num_proyectos_propuesta,
    (select count(*) from propuestas_evaluacion pe left join proyectos py on pe.cve_proyecto = py.cve_proyecto left join programas p on p.cve_programa = py.cve_programa where pe.id_propuesta_evaluacion in (select id_propuesta_evaluacion from calificaciones_propuesta ) and pg.cve_dependencia = p.cve_dependencia) as num_propuestas_calificadas
FROM 
    proyectos py  
    left join programas pg on py.cve_programa = pg.cve_programa
GROUP BY
    pg.cve_dependencia ;
