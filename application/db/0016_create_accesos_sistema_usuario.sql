DROP TABLE IF EXISTS accesos_sistema_usuario CASCADE;
CREATE TABLE accesos_sistema_usuario (
    cve_acceso serial,
    cve_usuario integer,
    cod_opcion text
);
