DROP TABLE IF EXISTS status_documentos_opinion CASCADE;
CREATE TABLE status_documentos_opinion (
    cve_status_documento_opinion text,
    desc_status_documento_opinion text
);

INSERT INTO status_documentos_opinion (cve_status_documento_opinion, desc_status_documento_opinion) VALUES ('en_proceso', 'En proceso');
INSERT INTO status_documentos_opinion (cve_status_documento_opinion, desc_status_documento_opinion) VALUES ('por_evaluar', 'Por evaluar');
INSERT INTO status_documentos_opinion (cve_status_documento_opinion, desc_status_documento_opinion) VALUES ('aprobado', 'Aprobado');

ALTER TABLE documentos_opinion
ALTER COLUMN status TYPE text;

ALTER TABLE valoraciones_documento_opinion 
ADD COLUMN status text;
