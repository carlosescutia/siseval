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

ALTER TABLE recomendaciones ADD COLUMN IF NOT EXISTS ponderacion integer;

INSERT INTO status_plan_accion (cve_status_plan_accion, desc_status_plan_accion) VALUES ('en_proceso', 'En proceso');
INSERT INTO status_plan_accion (cve_status_plan_accion, desc_status_plan_accion) VALUES ('por_evaluar', 'Por evaluar');
INSERT INTO status_plan_accion (cve_status_plan_accion, desc_status_plan_accion) VALUES ('aprobado', 'Aprobado');

INSERT INTO tipos_actor (descripcion) VALUES ('Específico');
INSERT INTO tipos_actor (descripcion) VALUES ('Institucional');
INSERT INTO tipos_actor (descripcion) VALUES ('Interinstitucional');
INSERT INTO tipos_actor (descripcion) VALUES ('Intergubernamental');
