/* Tablas de información del sistema */

DROP TABLE IF EXISTS proyectos CASCADE;
CREATE TABLE proyectos (
    id_proyecto serial,
    cve_proyecto text,
    cve_anterior_proyecto text,
    cve_dependencia integer,
    nom_proyecto text,
    cve_programa text,
    periodo integer,
    presupuesto_aprobado numeric (12,2),
    cve_tipo_gasto text,
    anexo_social integer
);

DROP TABLE IF EXISTS programas CASCADE;
CREATE TABLE programas (
    id_programa serial,
    cve_programa text,
    nom_programa text
);

DROP TABLE IF EXISTS evaluaciones CASCADE;
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
    liga_conac text,
    observaciones text
);

DROP TABLE IF EXISTS propuestas_evaluacion CASCADE;
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
    observaciones text,
    recomendaciones_previas integer,
    justificacion_no_atencion text,
    info_diagnostico integer,
    info_mir integer,
    info_reglasop integer,
    info_regsadm integer,
    info_fuentes_of integer,
    info_progpresup integer,
    info_padronben integer,
    info_lineamientos integer,
    info_guiasop integer,
    info_normativa integer,
    info_otro integer,
    otra_info_disponible text,
    clasificacion_supervisor integer,
    excluir_agenda integer,
    comentarios_exclusion text,
    monto_contratacion numeric(12,2)
);

DROP TABLE IF EXISTS tipos_evaluacion CASCADE;
CREATE TABLE tipos_evaluacion (
    id_tipo_evaluacion serial,
    nom_tipo_evaluacion text,
    orden integer,
);

DROP TABLE IF EXISTS justificaciones_evaluacion CASCADE;
CREATE TABLE justificaciones_evaluacion (
    id_justificacion_evaluacion serial,
    nom_justificacion_evaluacion text,
    orden integer
);

DROP TABLE IF EXISTS calificaciones_propuesta CASCADE;
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
    comentarios text,
    criterio_institucional integer
);

DROP TABLE IF EXISTS clasificaciones_supervisor CASCADE;
CREATE TABLE clasificaciones_supervisor (
    id_clasificacion_supervisor serial,
    cve_clasificacion_supervisor integer,
    nom_clasificacion_supervisor text,
    orden integer
);

DROP TABLE IF EXISTS probabilidades_inclusion CASCADE;
CREATE TABLE probabilidades_inclusion (
    id_probabilidad_inclusion serial,
    min integer,
    max integer,
    nom_probabilidad_inclusion text,
    orden integer
);

DROP TABLE IF EXISTS objetivos_desarrollo CASCADE;
CREATE TABLE objetivos_desarrollo (
    id_objetivo_desarrollo serial,
    cve_objetivo_desarrollo integer,
    nom_objetivo_desarrollo text
);

DROP TABLE IF EXISTS metas_ods CASCADE;
CREATE TABLE metas_ods (
    id_meta_ods serial,
    cve_meta_ods text,
    cve_objetivo_desarrollo integer,
    nom_meta_ods text
);

DROP TABLE IF EXISTS programas_metas CASCADE;
CREATE TABLE programas_metas (
    id_programa_meta serial,
    cve_programa text,
    cve_meta_ods text
);

DROP TABLE IF EXISTS semaforo_proyectos CASCADE;
CREATE TABLE semaforo_proyectos (
    id_semaforo_proyectos serial,
    cve_proyecto text,
    semaforo_22 text
);



/* Tablas de administración del sistema */

DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios (
    cve_usuario serial, 
    cve_dependencia integer,
    cve_rol text,
    nom_usuario text,
    usuario text,
    password text,
    activo integer
);

DROP TABLE IF EXISTS roles CASCADE;
CREATE TABLE roles (
    cve_rol text,
    nom_rol text
);

DROP TABLE IF EXISTS opciones_sistema CASCADE;
CREATE TABLE opciones_sistema (
    cve_opcion serial,
    cod_opcion text,
    nom_opcion text,
    otorgable integer
);

DROP TABLE IF EXISTS accesos_sistema CASCADE;
CREATE TABLE accesos_sistema (
    cve_acceso serial,
    cve_rol text,
    cod_opcion text
);

DROP TABLE IF EXISTS dependencias CASCADE;
CREATE TABLE dependencias (
    cve_dependencia serial,
    nom_dependencia text,
    nom_completo_dependencia text,
    carga_evaluaciones integer
);

DROP TABLE IF EXISTS bitacora CASCADE;
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

DROP TABLE IF EXISTS parametros_sistema CASCADE;
CREATE TABLE parametros_sistema (
    cve_parametro_sistema serial,
    nom_parametro_sistema text,
    valor_parametro_sistema text
);

DROP TABLE IF EXISTS eventos CASCADE;
CREATE TABLE eventos (
    id_evento serial,
    fecha_evento date,
    desc_evento text
);

DROP TABLE IF EXISTS documentos_opinion CASCADE;
CREATE TABLE documentos_opinion (
    cve_documento_opinion serial,
    id_propuesta_evaluacion integer,
    fecha_elaboracion date,
    instancia_evaluadora text,
    elaborado_por text,
    antecedentes text,
    status text
);

DROP TABLE IF EXISTS recomendaciones CASCADE;
CREATE TABLE recomendaciones (
    cve_recomendacion serial,
    cve_documento_opinion integer,
    desc_recomendacion text,
    clara text,
    relevante text,
    justificable text,
    factible text,
    id_tipo_actor integer,
    prioridad text,
    responsable text,
    postura text,
    justificacion text,
    ponderacion integer
);

DROP TABLE IF EXISTS status_documentos_opinion CASCADE;
CREATE TABLE status_documentos_opinion (
    cve_status_documento_opinion text,
    desc_status_documento_opinion text
);

DROP TABLE IF EXISTS valoraciones_documento_opinion CASCADE;
CREATE TABLE valoraciones_documento_opinion (
    cve_valoracion_documento_opinion serial,
    cve_documento_opinion integer,
    cve_dependencia integer,
    pertinencia integer,
    prioridad integer,
    fundamentada integer,
    observaciones text,
    status text
);

DROP TABLE IF EXISTS accesos_sistema_usuario CASCADE;
CREATE TABLE accesos_sistema_usuario (
    cve_acceso serial,
    cve_usuario integer,
    cod_opcion text
);

DROP TABLE IF EXISTS planes_accion CASCADE;
CREATE TABLE planes_accion (
    id_plan_accion serial,
    cve_documento_opinion integer,
    fecha_elaboracion date,
    status text
);

DROP TABLE IF EXISTS actividades CASCADE;
CREATE TABLE actividades (
    id_actividad serial,
    cve_recomendacion integer,
    desc_actividad text,
    fech_ini date,
    fech_fin date,
    area_responsable text,
    resultados_esperados text,
    ponderacion integer
);

DROP TABLE IF EXISTS status_plan_accion CASCADE;
CREATE TABLE status_plan_accion (
    cve_status_plan_accion text,
    desc_status_plan_accion text
);

DROP TABLE IF EXISTS valoraciones_plan_accion CASCADE;
CREATE TABLE valoraciones_plan_accion (
    id_valoracion_plan_accion serial,
    id_plan_accion integer,
    cve_dependencia integer,
    actividades_cumplimiento int,
    plazo_adecuado int,
    resultados_pertinentes int,
    observaciones text,
    status text
);

DROP TABLE IF EXISTS tipos_actor CASCADE;
CREATE TABLE tipos_actor (
    id serial,
    descripcion text
);

