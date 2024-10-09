DROP TABLE IF EXISTS valoraciones_evaluacion CASCADE;
CREATE TABLE valoraciones_evaluacion (
    id_valoracion_evaluacion serial,
    id_propuesta_evaluacion integer,
    informe integer,
    antecedentes integer,
    metodologia integer,
    informacion integer,
    analisis integer,
    conclusiones integer,
    acuerdos_institucionales integer,
    acuerdos_confidencialidad integer,
    derechos integer,
    orientacion integer,
    autonomia integer,
    genero integer,
    observaciones text
);
