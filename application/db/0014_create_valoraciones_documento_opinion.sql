DROP TABLE IF EXISTS valoraciones_documento_opinion CASCADE;
CREATE TABLE valoraciones_documento_opinion (
    cve_valoracion_documento_opinion serial,
    cve_documento_opinion integer,
    cve_dependencia integer,
    pertinencia integer,
    prioridad integer,
    fundamentada integer,
    observaciones text
);
