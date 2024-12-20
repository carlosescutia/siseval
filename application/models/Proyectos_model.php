<?php
class Proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_proyectos_dependencia($cve_dependencia, $anexo_social, $evaluaciones_propuestas) {
        $sql = ''
            .'select '
            .'py.*, pg.*,  '
            .'(select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) as status_actual, '
            .'(select count(distinct(cp.id_propuesta_evaluacion)) from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp. id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.cve_proyecto = py.cve_proyecto) as propuestas_calificadas, '
            .'(select count(*) from evaluaciones ev left join proyectos pry on ev.cve_proyecto = pry.cve_anterior_proyecto where pry.cve_proyecto = py.cve_proyecto) as status_previo, '
            .'(select count(*) as num_calif_dependencias from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp.id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.cve_proyecto = py.cve_proyecto) as num_calif_dependencias '
            .'from '
            .'proyectos py '
            .'left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia '
            .'where '
            .'pg.cve_dependencia::text LIKE ? '
            .'';

        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        if ($anexo_social > 0) {
            $sql .= ' and py.anexo_social = ?';
            array_push($parametros, "$anexo_social");
        }
        if ($evaluaciones_propuestas == '1') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) > 0';
        }
        if ($evaluaciones_propuestas == '2') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) = 0';
        }
        $sql .= ' order by pg.cve_programa, py.cve_proyecto;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_proyecto($cve_proyecto, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' or $cve_rol == 'sup' or $cve_rol == 'sec') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.*, d.nom_dependencia from proyectos py left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia left join dependencias d on pg.cve_dependencia = d.cve_dependencia where py.cve_proyecto = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($cve_proyecto, $cve_dependencia));
        return $query->row_array();
    }

    public function get_proyecto_id($id_proyecto) {
        $sql = 'select * from proyectos where id_proyecto = ?';
        $query = $this->db->query($sql, array($id_proyecto));
        return $query->row_array();
    }

    public function get_proyecto_anterior($cve_anterior_proyecto, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' or $cve_rol == 'sup' or $cve_rol == 'sec') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.* from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where py.cve_anterior_proyecto = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($cve_anterior_proyecto, $cve_dependencia));
        return $query->row_array();
    }

    public function get_programas_agenda_evaluacion($cve_dependencia) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
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
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_publico($limite=null, $inicio=null) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join status_documentos_opinion sdop on sdop.cve_status_documento_opinion = dop.status "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."left join status_plan_accion spa on spa.cve_status_plan_accion = pa.status "
            ."left join valoraciones_evaluador ver on ver.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."left join valoraciones_evaluacion ven on ven.id_propuesta_evaluacion = pe.id_propuesta_evaluacion "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
            ."limit " . $limite . " offset " . $inicio
            ."";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function num_programas_agenda_evaluacion_publico() {
        $sql = ""
            ."select "
            ."count(*) as num_programas "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."where "
            ."coalesce(pe.excluir_agenda,0) <> 1 "
            ."";

        $query = $this->db->query($sql);
        return $query->row_array()['num_programas'];
    }


    public function get_programas_agenda_evaluacion_archivos($limite=null, $inicio=null) {
        // lista de proyectos con archivos
        $dire = './doc/' ;
        $archivos = directory_map($dire);
        $lista = array();
        foreach ($archivos as $archivo) {
            $tipoarch = substr($archivo, 1, 2);
            if (in_array($tipoarch, array('if', 'tr'))) {
                $nom_arch = substr($archivo, 0, -4);
                $cve_proyecto = substr($nom_arch, 4);
                array_push($lista, $cve_proyecto);
            }
        }
        $lista_final = array_unique($lista);

        $sql = ""
            ."select "
            ."pe.id_propuesta_evaluacion, py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, pa.id_plan_accion "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."left join documentos_opinion dop on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."where "
            ."lower(pe.cve_proyecto) || te.abrev_tipo_evaluacion in ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
            ."limit " . $limite . " offset " . $inicio
            ."";

        $query = $this->db->query($sql, array($lista_final));
        return $query->result_array();
    }

    public function num_programas_agenda_evaluacion_archivos($limite=null, $inicio=null) {
        // lista de proyectos con archivos
        $dire = './doc/' ;
        $archivos = directory_map($dire);
        $lista = array();
        foreach ($archivos as $archivo) {
            $tipoarch = substr($archivo, 1, 2);
            if (in_array($tipoarch, array('if', 'tr'))) {
                $nom_arch = substr($archivo, 0, -4);
                $cve_proyecto = substr($nom_arch, 4);
                array_push($lista, $cve_proyecto);
            }
        }
        $lista_final = array_unique($lista);

        $sql = ""
            ."select "
            ."count (*) as num_programas "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."where "
            ."lower(pe.cve_proyecto) || te.abrev_tipo_evaluacion in ? "
            ."and coalesce(pe.excluir_agenda,0) <> 1 "
            ."";

        $query = $this->db->query($sql, array($lista_final));
        return $query->row_array()['num_programas'];
    }


    public function get_propuestas_evaluacion($cve_dependencia) {
        $sql = ''
            .'select  '
            .'d.nom_dependencia, pg.cve_programa, pg.nom_programa, pe.cve_proyecto,  '
            .'py.nom_proyecto, te.nom_tipo_evaluacion '
            .'from  '
            .'propuestas_evaluacion pe  '
            .'left join proyectos py on pe.cve_proyecto = py.cve_proyecto  '
            .'left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia '
            .'left join dependencias d on py.cve_dependencia = d.cve_dependencia '
            .'left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion '
            .'where  '
            .'py.cve_dependencia::text LIKE ? '
            .'order by '
            .'d.nom_dependencia, pg.cve_programa, pe.cve_proyecto  '
            .'';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    public function get_estadisticas_proyectos_dependencia($cve_dependencia) {
        $sql = 'select sum(num_proyectos) as num_proyectos, sum(num_proyectos_propuesta) as num_proyectos_propuesta, sum(num_propuestas_calificadas) as num_propuestas_calificadas from estadisticas_dependencia where cve_dependencia::text LIKE ?';
        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        $query = $this->db->query($sql, $parametros);
        return $query->row_array();
    }

    public function get_consecutivo_dependencia($cve_dependencia)
    {
        $sql = "select max(right(py.cve_proyecto, 2)) as consecutivo from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where left(pg.cve_programa, 3) = 'PRO' and pg.cve_dependencia = ?";
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->row_array();
    }

    public function get_num_proyectos_ods()
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
            ."group by "
            ."py.cve_proyecto, py.cve_programa, mo.cve_objetivo_desarrollo "
            .") as t "
            ."right join objetivos_desarrollo od on od.cve_objetivo_desarrollo = t.cve_objetivo_desarrollo "
            ."group by "
            ."od.cve_objetivo_desarrollo, od.nom_objetivo_desarrollo "
            ."order by "
            ."od.cve_objetivo_desarrollo "
            ."";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_plan_accion($cve_dependencia) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto, pe.objetivo, pe.monto_contratacion,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, pe.id_propuesta_evaluacion, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, "
            ."pcp.puntaje, pcp.probabilidad, dop.cve_documento_opinion, dop.status as status_documento_opinion, sdop.desc_status_documento_opinion, "
            ."pa.id_plan_accion, pa.status as status_plan_accion, spa.desc_status_plan_accion, "
            ."ver.id_valoracion_evaluador, (ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador, "
            ."ven.id_valoracion_evaluacion, (ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion, "
            ."pe.url_sitio_tr, pe.url_arch_tr, pe.url_sitio_if, pe.url_arch_if, pe.url_sitio_fc, pe.url_arch_fc, pe.url_sitio_do, pe.url_arch_do, pe.url_sitio_pa, pe.url_arch_pa, "
            ."(with tmp_recomend as ( with tmp_activ as ( select pa.id_plan_accion, a.cve_recomendacion, a.registro_avance::numeric(10,2), a.resultados_esperados::numeric(10,2), round(a.registro_avance::numeric(10,2) / a.resultados_esperados::numeric(10,2) * 100) as promedio, r.ponderacion from actividades a left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion left join planes_accion pa on pa.cve_documento_opinion = r.cve_documento_opinion) select id_plan_accion, cve_recomendacion, ponderacion, sum(promedio) as suma, count(*) as registros, round(sum(promedio) / count(*)) as promedio, (sum(promedio) / count(*) * ponderacion / 100)::integer as promedio_ponderado from tmp_activ where id_plan_accion = pa.id_plan_accion group by id_plan_accion, ponderacion, cve_recomendacion) select sum(promedio_ponderado) from tmp_recomend ) as cumplimiento "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
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
            ."and pa.id_plan_accion > 0 "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
            ."";

        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    public function get_proyecto_plan_accion($id_plan_accion) {
        $sql = ""
            ."select "
            ."pe.cve_proyecto, py.nom_proyecto, py.periodo, te.nom_tipo_evaluacion, dpe.nom_dependencia as nom_dependencia_propuesta "
            ."from "
            ."propuestas_evaluacion pe "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
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

}
