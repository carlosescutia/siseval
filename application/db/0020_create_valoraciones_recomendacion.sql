DROP TABLE IF EXISTS valoraciones_recomendacion CASCADE;
CREATE TABLE valoraciones_recomendacion (
    cve_valoracion_recomendacion serial,
    cve_recomendacion integer,
    cve_dependencia integer,
    pertinencia integer,
    prioridad integer,
    fundamentada integer,
    observaciones text,
    status text
);

DROP TABLE IF EXISTS valoraciones_documento_opinion CASCADE;
