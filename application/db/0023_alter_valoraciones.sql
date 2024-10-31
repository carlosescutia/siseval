ALTER TABLE valoraciones_evaluador DROP COLUMN IF EXISTS evaluador;
ALTER TABLE valoraciones_evaluador ADD COLUMN IF NOT EXISTS id_evaluador integer;
ALTER TABLE valoraciones_evaluador ADD COLUMN IF NOT EXISTS cargo text;

ALTER TABLE valoraciones_evaluacion ADD COLUMN IF NOT EXISTS elaborado text;
ALTER TABLE valoraciones_evaluacion ADD COLUMN IF NOT EXISTS cargo text;

ALTER TABLE actividades ADD COLUMN IF NOT EXISTS unidad_medida text;

DROP TABLE IF EXISTS evaluadores;
CREATE TABLE evaluadores (
    id_evaluador integer primary key,
    nom_evaluador text,
    observaciones text
);

INSERT INTO opciones_sistema (cod_opcion, nom_opcion, otorgable) VALUES
    ('evaluador.can_edit','Editar evaluadores',1);

INSERT INTO accesos_sistema(cve_rol, cod_opcion) VALUES
    ('usr', 'evaluador.can_edit');
