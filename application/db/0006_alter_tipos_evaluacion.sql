ALTER TABLE tipos_evaluacion
ADD COLUMN abrev_tipo_evaluacion text;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'cp' where id_tipo_evaluacion = 1 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'cr' where id_tipo_evaluacion = 2 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'cs' where id_tipo_evaluacion = 3 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'de' where id_tipo_evaluacion = 4 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'di' where id_tipo_evaluacion = 5 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'es' where id_tipo_evaluacion = 6 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'fd' where id_tipo_evaluacion = 7 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'im' where id_tipo_evaluacion = 8 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'in' where id_tipo_evaluacion = 9 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'pr' where id_tipo_evaluacion = 10 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 're' where id_tipo_evaluacion = 11 ;
UPDATE tipos_evaluacion set abrev_tipo_evaluacion = 'ot' where id_tipo_evaluacion = 12 ;
