/*
Función get_dependencia_periodo(periodo)
-----------------------
Obtiene valores de dependencias del periodo igual o inmediato anterior de la tabla dependencias_periodos
Si no existe, usa valores de la tabla dependencia
 */
create or replace function get_dependencia_periodo(param_cve_dependencia int, param_periodo int)
returns table(cve_dependencia int, periodo int, nom_dependencia text, nom_completo_dependencia text) as 
$$
begin
    return query
        select
            dp.cve_dependencia, dp.periodo, dp.nom_dependencia, dp.nom_completo_dependencia
        from
            dependencias_periodos dp
        where
            dp.cve_dependencia = param_cve_dependencia
            and dp.periodo <= param_periodo
    union
        select
            d.cve_dependencia, '0' as periodo, d.nom_dependencia, d.nom_completo_dependencia
        from
            dependencias d
        where
            d.cve_dependencia = param_cve_dependencia
        order by
            periodo desc
        limit 1
    ;
end;
$$ language plpgsql strict immutable;


