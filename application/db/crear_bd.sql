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
    cve_tipo_gasto text
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
    obligatorias integer,
    solicitud integer,
    intervenciones_estrategicas integer,
    intervenciones_relevantes integer,
    peso_presupuestario integer,
    tiempo_ejecucion integer,
    informacion_disponible integer,
    mayor_cobertura integer,
    tiempo_razonable integer,
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
    nom_completo_dependencia text
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
