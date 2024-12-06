ALTER TABLE actividades ADD COLUMN IF NOT EXISTS registro_avance integer;
ALTER TABLE actividades ADD COLUMN IF NOT EXISTS comentarios_avance text;
