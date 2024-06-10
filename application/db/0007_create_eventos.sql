DROP TABLE IF EXISTS eventos CASCADE;
CREATE TABLE eventos (
    id_evento serial,
    fecha_evento date,
    desc_evento text
);
