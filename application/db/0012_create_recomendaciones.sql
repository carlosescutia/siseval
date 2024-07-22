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
    justificacion text
);
