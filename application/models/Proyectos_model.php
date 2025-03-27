<?php
class Proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    public function get_proyectos_dependencia($cve_dependencia, $periodo, $anexo_social, $evaluaciones_propuestas) {
        $sql = ''
            .'select '
            .'py.*, pg.*,  '
            .'(select count(*) from propuestas_evaluacion where id_proyecto = py.id_proyecto) as evaluaciones_propuestas, '
            .'(select count(distinct(cp.id_propuesta_evaluacion)) from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp. id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.id_proyecto = py.id_proyecto) as propuestas_calificadas, '
            .'(select count(*) from evaluaciones ev left join proyectos pry on ev.cve_proyecto = pry.cve_anterior_proyecto where pry.id_proyecto = py.id_proyecto and ev.periodo < py.periodo) as evaluaciones_previas, '
            .'(select count(*) as num_calif_dependencias from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp.id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.id_proyecto = py.id_proyecto) as num_calif_dependencias, '
            .'(select  '
            .'(case  '
            .'when position(\'no_calificada\' in  string_agg(distinct(pcp.status_calificacion), \',\')) > 0  '
                .'then \'no_calificada\'  '
                .'when position(\'no_calificada\' in  string_agg(distinct(pcp.status_calificacion), \',\')) = 0 '
                .'and position(\'parcialmente_calificada\' in  string_agg(distinct(pcp.status_calificacion), \',\')) > 0  '
                .'then \'parcialmente_calificada\'  '
                .'when string_agg(distinct(pcp.status_calificacion), \',\') = \'totalmente_calificada\' '
            .'then \'totalmente_calificada\' '
            .'end) '
            .'from  '
            .'puntaje_calificacion_propuesta pcp '
            .'where '
            .'pcp.id_proyecto = py.id_proyecto '
            .') as status_propuesta '
            .'from '
            .'proyectos py '
            .'left join programas pg on py.cve_programa = pg.cve_programa '
            .'where '
            .'py.cve_dependencia::text LIKE ? '
            .'and py.periodo = ? '
            .'';

        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        array_push($parametros, "$periodo");
        if ($anexo_social > 0) {
            $sql .= ' and py.anexo_social = ?';
            array_push($parametros, "$anexo_social");
        }
        if ($evaluaciones_propuestas == '1') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where id_proyecto = py.id_proyecto) > 0';
        }
        if ($evaluaciones_propuestas == '2') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where id_proyecto = py.id_proyecto) = 0';
        }
        $sql .= ' order by pg.cve_programa, py.cve_proyecto;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_anios_proyectos()
    {
        $sql = 'select distinct periodo from proyectos order by periodo desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_proyecto($id_proyecto, $cve_dependencia, $cve_rol, $periodo) {
        if ($cve_rol == 'adm' or $cve_rol == 'sup' or $cve_rol == 'sec') {
            $cve_dependencia = '%';
        }
        $sql = ''
            .'select p'
            .'y.*, d.nom_dependencia '
            .'from '
            .'proyectos py '
            .'left join programas pg on py.cve_programa = pg.cve_programa '
            ."left join get_dependencia_periodo(py.cve_dependencia, ?) d on py.cve_dependencia = d.cve_dependencia "
            .'where '
            .'py.id_proyecto = ? '
            .'and py.cve_dependencia::text LIKE ? '
            .'';
        $query = $this->db->query($sql, array($periodo, $id_proyecto, $cve_dependencia));
        return $query->row_array();
    }

    public function get_proyecto_id($id_proyecto) {
        $sql = 'select * from proyectos where id_proyecto = ?';
        $query = $this->db->query($sql, array($id_proyecto));
        return $query->row_array();
    }

    public function get_proyecto_anterior($cve_anterior_proyecto, $cve_dependencia, $cve_rol, $periodo) {
        if ($cve_rol == 'adm' or $cve_rol == 'sup' or $cve_rol == 'sec') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.* from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where py.cve_anterior_proyecto = ? and py.cve_dependencia::text LIKE ? and py.periodo = ? ';
        $query = $this->db->query($sql, array($cve_anterior_proyecto, $cve_dependencia, $periodo));
        return $query->row_array();
    }

    public function get_programas_agenda_evaluacion_reporte($cve_dependencia, $periodo, $salida=null) {
        $sql = ""
            ."select "
            ."d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, py.cve_proyecto, "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, "
            ."te.nom_tipo_evaluacion, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join get_dependencia_periodo(py.cve_dependencia, ?) d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.id_proyecto = pcp.id_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join get_dependencia_periodo(pe.cve_dependencia, ?) dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($periodo, $periodo, $cve_dependencia, $periodo));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_propuestas_evaluacion($cve_dependencia, $periodo, $salida=null) {
        $sql = ''
            .'select  '
            .'d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.cve_proyecto,  '
            .'py.nom_proyecto, te.nom_tipo_evaluacion '
            .'from  '
            .'propuestas_evaluacion pe  '
            .'left join proyectos py on pe.id_proyecto = py.id_proyecto  '
            .'left join programas pg on py.cve_programa = pg.cve_programa '
            ."left join get_dependencia_periodo(py.cve_dependencia, ?) d on py.cve_dependencia = d.cve_dependencia "
            .'left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion '
            .'where  '
            .'py.cve_dependencia::text LIKE ? '
            .'and py.periodo = ? '
            .'order by '
            .'d.nom_dependencia, pg.cve_programa, py.cve_proyecto  '
            .'';
        $query = $this->db->query($sql, array($periodo, $cve_dependencia, $periodo));

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_estadisticas_proyectos_dependencia($cve_dependencia, $periodo) {
        $sql = ''
            .'select '
            .'sum(num_proyectos) as num_proyectos, sum(num_proyectos_propuesta) as num_proyectos_propuesta, sum(num_propuestas_calificadas) as num_propuestas_calificadas  '
            .'from  '
            .'estadisticas_dependencia  '
            .'where  '
            .'cve_dependencia::text LIKE ? '
            .'and periodo = ? '
            .'';
        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        array_push($parametros, "$periodo");
        $query = $this->db->query($sql, $parametros);
        return $query->row_array();
    }

    public function get_consecutivo_dependencia($cve_dependencia)
    {
        $sql = "select max(right(py.cve_proyecto, 2)) as consecutivo from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where left(pg.cve_programa, 3) = 'PRO' and py.cve_dependencia = ?";
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->row_array();
    }

    public function get_num_proyectos_ods($periodo)
    {
        $sql = ""
            ."select "
            ."od.cve_objetivo_desarrollo, od.nom_objetivo_desarrollo, count(t.cve_proyecto) as num_proyectos_ods "
            ."from "
            ."( "
            ."select "
            ."py.cve_proyecto, py.cve_programa, mo.cve_objetivo_desarrollo "
            ."from "
            ."proyectos py "
            ."left join programas_metas pm on pm.cve_programa = py.cve_programa "
            ."left join metas_ods mo on mo.cve_meta_ods = pm.cve_meta_ods "
            ."where "
            ."py.periodo = ? "
            ."group by "
            ."py.cve_proyecto, py.cve_programa, mo.cve_objetivo_desarrollo "
            .") as t "
            ."right join objetivos_desarrollo od on od.cve_objetivo_desarrollo = t.cve_objetivo_desarrollo "
            ."group by "
            ."od.cve_objetivo_desarrollo, od.nom_objetivo_desarrollo "
            ."order by "
            ."od.cve_objetivo_desarrollo "
            ."";
        $query = $this->db->query($sql, array($periodo));
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_gestion($cve_dependencia, $periodo) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, py.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.nom_tipo_evaluacion, cs.cve_clasificacion_supervisor, pe.id_proyecto, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia, $periodo));
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_ejecucion($cve_dependencia, $periodo) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, py.periodo, py.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.nom_tipo_evaluacion, cs.cve_clasificacion_supervisor, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia, $periodo));

        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_valoracion($cve_dependencia, $periodo) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, py.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join status_documentos_opinion sdop on sdop.cve_status_documento_opinion = dop.status "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."left join status_plan_accion spa on spa.cve_status_plan_accion = pa.status "
            ."left join valoraciones_evaluador ver on ver.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."left join valoraciones_evaluacion ven on ven.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia, $periodo));

        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_plan_accion($cve_dependencia, $periodo) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, py.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa, "
            ."(with tmp_recomend as ( with tmp_activ as ( select pa.id_plan_accion, a.cve_recomendacion, a.registro_avance::numeric(10,2), a.resultados_esperados::numeric(10,2), round(a.registro_avance::numeric(10,2) / a.resultados_esperados::numeric(10,2) * 100) as promedio, r.ponderacion from actividades a left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion left join planes_accion pa on pa.cve_documento_opinion = r.cve_documento_opinion) select id_plan_accion, cve_recomendacion, ponderacion, sum(promedio) as suma, count(*) as registros, round(sum(promedio) / count(*)) as promedio, (sum(promedio) / count(*) * ponderacion / 100)::integer as promedio_ponderado from tmp_activ where id_plan_accion = pa.id_plan_accion group by id_plan_accion, ponderacion, cve_recomendacion) select sum(promedio_ponderado) from tmp_recomend ) as cumplimiento "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.id_proyecto = pcp.id_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join status_documentos_opinion sdop on sdop.cve_status_documento_opinion = dop.status "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."left join status_plan_accion spa on spa.cve_status_plan_accion = pa.status "
            ."left join valoraciones_evaluador ver on ver.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."left join valoraciones_evaluacion ven on ven.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."and pa.id_plan_accion > 0 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia, $periodo));
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_publico($limite=null, $inicio=null) {
        // obtener lista de posibles archivos para cada registro
        $sql = ""
            ."select "
            ."pe.id_propuesta_evaluacion "
            ."from "
            ."propuestas_evaluacion pe  "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."pe.id_propuesta_evaluacion "
            ."";
        $query = $this->db->query($sql);
        $proyectos = $query->result_array();
        $tipo_archivo = 'pdf';
        $dir_docs = './doc/';
        $docs_por_iniciar = [];
        $docs_en_proceso = [];
        $docs_concluido = [];
        $docs_cancelado = [];
        foreach ($proyectos as $proyectos_item) {
            $prefijo = 'ct' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $contrato_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'on' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $oficio_notificacion_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'if' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $informe_final_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'cl' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $cancelacion_fs = $dir_docs . $nombre_archivo;

            $status = 'por_iniciar';
            if ( file_exists($contrato_fs) or file_exists($oficio_notificacion_fs) ) {
                $status = 'en_proceso' ;
            }
            if ( file_exists($informe_final_fs) ) {
                $status = 'concluido' ;
            }
            if ( file_exists($cancelacion_fs) ) {
                $status = 'cancelado' ;
            }

            switch ($status) {
                case 'por_iniciar':
                    array_push($docs_por_iniciar, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'en_proceso':
                    array_push($docs_en_proceso, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'concluido':
                    array_push($docs_concluido, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'cancelado':
                    array_push($docs_cancelado, $proyectos_item['id_propuesta_evaluacion']);
                    break;
            };
        }
        $lista_por_iniciar = implode(',', $docs_por_iniciar);
        if (empty($lista_por_iniciar)) {
            $lista_por_iniciar = '0';
        }
        $lista_en_proceso = implode(',', $docs_en_proceso);
        if (empty($lista_en_proceso)) {
            $lista_en_proceso = '0';
        }
        $lista_concluido = implode(',', $docs_concluido);
        if (empty($lista_concluido)) {
            $lista_concluido = '0';
        }
        $lista_cancelado = implode(',', $docs_cancelado);
        if (empty($lista_cancelado)) {
            $lista_cancelado = '0';
        }

        $sql = ""
            ."select "
            ."d.nom_dependencia, "
            ."py.periodo, py.cve_proyecto, py.nom_proyecto, "
            ."pe.id_propuesta_evaluacion, "
            ."te.nom_tipo_evaluacion, "
            ."dop.cve_documento_opinion,  "
            ."pa.id_plan_accion, "
            ."(case "
            ."when pe.id_propuesta_evaluacion in (" . $lista_por_iniciar . ") then 'por_iniciar' "
            ."when pe.id_propuesta_evaluacion in (" . $lista_en_proceso . ") then 'en_proceso' "
            ."when pe.id_propuesta_evaluacion in (" . $lista_concluido . ") then 'concluido' "
            ."when pe.id_propuesta_evaluacion in (" . $lista_cancelado . ") then 'cancelado' "
            ."end) as status "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."and pe.id_propuesta_evaluacion not in (" . $lista_por_iniciar .") "
            ."order by "
            ."py.periodo desc, d.nom_dependencia, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."limit " . $limite . " offset " . $inicio
            ."";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function num_programas_agenda_evaluacion_publico() {
        // obtener lista de posibles archivos para cada registro
        $sql = ""
            ."select "
            ."pe.id_propuesta_evaluacion "
            ."from "
            ."propuestas_evaluacion pe  "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."pe.id_propuesta_evaluacion "
            ."";
        $query = $this->db->query($sql);
        $proyectos = $query->result_array();
        $tipo_archivo = 'pdf';
        $dir_docs = './doc/';
        $docs_por_iniciar = [];
        $docs_en_proceso = [];
        $docs_concluido = [];
        $docs_cancelado = [];
        foreach ($proyectos as $proyectos_item) {
            $prefijo = 'ct' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $contrato_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'on' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $oficio_notificacion_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'if' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $informe_final_fs = $dir_docs . $nombre_archivo;

            $prefijo = 'cl' ;
            $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
            $cancelacion_fs = $dir_docs . $nombre_archivo;

            $status = 'por_iniciar';
            if ( file_exists($contrato_fs) or file_exists($oficio_notificacion_fs) ) {
                $status = 'en_proceso' ;
            }
            if ( file_exists($informe_final_fs) ) {
                $status = 'concluido' ;
            }
            if ( file_exists($cancelacion_fs) ) {
                $status = 'cancelado' ;
            }

            switch ($status) {
                case 'por_iniciar':
                    array_push($docs_por_iniciar, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'en_proceso':
                    array_push($docs_en_proceso, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'concluido':
                    array_push($docs_concluido, $proyectos_item['id_propuesta_evaluacion']);
                    break;
                case 'cancelado':
                    array_push($docs_cancelado, $proyectos_item['id_propuesta_evaluacion']);
                    break;
            };
        }
        $lista_por_iniciar = implode(',', $docs_por_iniciar);
        if (empty($lista_por_iniciar)) {
            $lista_por_iniciar = '0';
        }
        $lista_en_proceso = implode(',', $docs_en_proceso);
        if (empty($lista_en_proceso)) {
            $lista_en_proceso = '0';
        }
        $lista_concluido = implode(',', $docs_concluido);
        if (empty($lista_concluido)) {
            $lista_concluido = '0';
        }
        $lista_cancelado = implode(',', $docs_cancelado);
        if (empty($lista_cancelado)) {
            $lista_cancelado = '0';
        }

        $sql = ""
            ."select "
            ."count(*) as num_programas "
            ."from "
            ."propuestas_evaluacion pe  "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."and pe.id_propuesta_evaluacion not in (" . $lista_por_iniciar .") "
            ."";
        $query = $this->db->query($sql);
        return $query->row_array()['num_programas'];
    }


    public function get_proyecto_plan_accion($id_plan_accion) {
        $sql = ""
            ."select "
            ."py.cve_proyecto, py.nom_proyecto, py.periodo, te.nom_tipo_evaluacion, dpe.nom_dependencia as nom_dependencia_propuesta "
            ."from "
            ."propuestas_evaluacion pe "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."where "
            ."pa.id_plan_accion = ? "
            ."";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array();
    }


    public function guardar($data, $id_proyecto)
    {
        if ($id_proyecto) {
            $this->db->where('id_proyecto', $id_proyecto);
            $this->db->update('proyectos', $data);
            $id = $id_proyecto;
        } else {
            $this->db->insert('proyectos', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_proyecto)
    {
        $this->db->where('id_proyecto', $id_proyecto);
        $result = $this->db->delete('proyectos');
    }

    public function get_programas_agenda_evaluacion_original($cve_dependencia) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, py.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.id_proyecto = py.id_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.id_proyecto = pcp.id_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join status_documentos_opinion sdop on sdop.cve_status_documento_opinion = dop.status "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."left join status_plan_accion spa on spa.cve_status_plan_accion = pa.status "
            ."left join valoraciones_evaluador ver on ver.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."left join valoraciones_evaluacion ven on ven.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."where "
            ."py.cve_dependencia::text LIKE ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, py.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia));

        return $query->result_array();
    }


}
