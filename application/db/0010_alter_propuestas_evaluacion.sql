ALTER TABLE propuestas_evaluacion
ADD COLUMN IF NOT EXISTS monto_contratacion numeric(12,2);
