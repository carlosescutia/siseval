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
    fecha_final_cronograma date,
    fecha_final_efectiva date,
    finalizo_cronograma text,
    metodo_financiamiento text,
    nom_evaluador text,
    costo_total_evaluacion numeric(12,2),
    liga_general_informe_evaluacion text,
    liga_directa_informe_evaluacion text,
    origen_aae text,
    documento_probatorio_financiamiento text,
    dependencia_responsable text
);

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
