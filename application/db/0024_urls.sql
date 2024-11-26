ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_sitio_tr text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_arch_tr text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_sitio_if text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_arch_if text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_sitio_fc text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_arch_fc text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_sitio_do text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_arch_do text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_sitio_pa text;
ALTER TABLE propuestas_evaluacion ADD COLUMN IF NOT EXISTS url_arch_pa text;


INSERT INTO opciones_sistema (cod_opcion, nom_opcion, otorgable) VALUES
    ('urls.can_edit','Editar urls',1);

INSERT INTO accesos_sistema (cve_rol, cod_opcion) VALUES
    ('sec','urls.can_edit');
