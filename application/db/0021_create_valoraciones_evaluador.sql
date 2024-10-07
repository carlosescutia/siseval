DROP TABLE IF EXISTS valoraciones_evaluador CASCADE;
CREATE TABLE valoraciones_evaluador (
    id_valoracion_evaluador serial,
    id_propuesta_evaluacion integer,
    evaluador text,
    puntualidad integer,
    solidez integer,
    objetividad integer,
    claridad integer,
    disponibilidad integer,
    observaciones text,
    elaborado text
);
