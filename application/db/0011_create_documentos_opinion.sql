DROP TABLE IF EXISTS documentos_opinion CASCADE;
CREATE TABLE documentos_opinion (
    cve_documento_opinion serial,
    id_propuesta_evaluacion integer,
    fecha_elaboracion date,
    instancia_evaluadora text,
    elaborado_por text,
    antecedentes text,
    status integer
);
