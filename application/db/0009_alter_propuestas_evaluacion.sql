ALTER TABLE propuestas_evaluacion
ADD COLUMN IF NOT EXISTS excluir_agenda integer;

ALTER TABLE propuestas_evaluacion
ADD COLUMN IF NOT EXISTS comentarios_exclusion text;
