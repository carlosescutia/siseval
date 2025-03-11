ALTER TABLE probabilidades_inclusion ADD COLUMN IF NOT EXISTS periodo integer ;
ALTER TABLE semaforo_proyectos ADD COLUMN IF NOT EXISTS periodo integer ;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS id_proyecto integer ;


DROP TABLE IF EXISTS periodos;
CREATE TABLE periodos (
    id_periodo serial,
    nom_periodo integer,
    num_supervisores integer
);

DROP TABLE IF EXISTS criterios_calificacion CASCADE;
CREATE TABLE criterios_calificacion (
    id_criterio_calificacion serial,
    nom_criterio text
);

DROP TABLE IF EXISTS criterios_calificacion_periodo CASCADE;
CREATE TABLE criterios_calificacion_periodo (
    id_criterio_calificacion_periodo serial,
    nom_criterio text,
    periodo integer
);

DROP TABLE IF EXISTS dependencias_periodos CASCADE;
CREATE TABLE dependencias_periodos (
    id_dependencia_periodo serial,
    cve_dependencia integer,
    periodo integer,
    nom_dependencia text,
    nom_completo_dependencia text
);

DROP TABLE IF EXISTS nocarga_evaluaciones;
CREATE TABLE nocarga_evaluaciones (
    id_nocarga_evaluacion serial,
    cve_dependencia integer,
    periodo integer
);

ALTER TABLE dependencias DROP COLUMN IF EXISTS carga_evaluaciones;
ALTER TABLE propuestas_evaluacion DROP COLUMN IF EXISTS cve_proyecto ;

ALTER TABLE actividades ALTER COLUMN resultados_esperados TYPE integer USING resultados_esperados::integer;
ALTER TABLE actividades ALTER COLUMN unidad_medida TYPE integer USING unidad_medida::integer;

ALTER TABLE tipos_evaluacion DROP COLUMN IF EXISTS abrev_tipo_evaluacion;
