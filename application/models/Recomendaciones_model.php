<?php
class Recomendaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_recomendaciones() {
        $sql = 'select * from recomendaciones order by cve_recomendacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_recomendaciones_doc_op($cve_documento_opinion) {
        $sql = 'select * from recomendaciones where cve_documento_opinion = ? order by cve_recomendacion;';
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->result_array();
    }

    public function get_recomendaciones_plan_accion($id_plan_accion) {
        $sql = ''
            ."select "
            ."r.cve_recomendacion, r.desc_recomendacion, r.id_tipo_actor, tac.descripcion as desc_tipo_actor, "
            ."(case "
            ."when r.prioridad = 'a' then 'Alto' "
            ."when r.prioridad = 'm' then 'Medio' "
            ."when r.prioridad = 'b' then 'Bajo' "
            ."end) as nivel_prioridad, "
            ."r.postura, r.ponderacion, dop.cve_documento_opinion, pa.id_plan_accion "
            ."from "
            ."recomendaciones r "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."left join tipos_actor tac on tac.id = r.id_tipo_actor "
            ."where pa.id_plan_accion = ? "
            ."and r.postura = 'a' "
            ."";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->result_array();
    }

    public function get_ponderacion_recomendaciones_plan_accion($id_plan_accion) {
        $sql = ""
            ."select "
            ."sum(r.ponderacion) as ponderacion_recomendaciones_plan_accion "
            ."from "
            ."recomendaciones r "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join planes_accion pa on pa.cve_documento_opinion = dop.cve_documento_opinion "
            ."where pa.id_plan_accion = ? "
            ."and r.postura = 'a' "
            ."";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['ponderacion_recomendaciones_plan_accion'] ?? null ;
    }

    public function get_recomendacion($cve_recomendacion) {
        $sql = 'select * from recomendaciones where cve_recomendacion = ?;';
        $query = $this->db->query($sql, array($cve_recomendacion));
        return $query->row_array();
    }

    public function get_num_recomendaciones_documento_opinion($cve_documento_opinion) {
        $sql = 'select count(*) as num_recomendaciones_documento_opinion from recomendaciones where cve_documento_opinion = ?';
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->row_array()['num_recomendaciones_documento_opinion'];
    }

    public function get_num_recomendaciones($dependencia, $periodo, $tipo_evaluacion) {
        $sql = ""
            ."select "
            ."count(*) as num_recomendaciones "
            ."from "
            ."recomendaciones r "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join proyectos py on py.id_proyecto = pe.id_proyecto "
            ."where py.cve_dependencia::text LIKE ? "
            ."";
        $parametros = array();
        array_push($parametros, "$dependencia");
        if ($periodo > 0) {
            $sql .= ' and py.periodo = ?';
            array_push($parametros, "$periodo");
        }
        if ($tipo_evaluacion > 0) {
            $sql .= ' and pe.id_tipo_evaluacion = ?';
            array_push($parametros, "$tipo_evaluacion");
        }
        $query = $this->db->query($sql, $parametros);
        return $query->row_array()['num_recomendaciones'] ?? null ;
    }

    public function get_num_recomendaciones_aceptadas($dependencia, $periodo, $tipo_evaluacion) {
        $sql = ""
            ."select "
            ."count(*) as num_recomendaciones_aceptadas "
            ."from "
            ."recomendaciones r "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join proyectos py on py.id_proyecto = pe.id_proyecto "
            ."where py.cve_dependencia::text LIKE ? "
            ."and r.postura = 'a' "
            ."";
        $parametros = array();
        array_push($parametros, "$dependencia");
        if ($periodo > 0) {
            $sql .= ' and py.periodo = ?';
            array_push($parametros, "$periodo");
        }
        if ($tipo_evaluacion > 0) {
            $sql .= ' and pe.id_tipo_evaluacion = ?';
            array_push($parametros, "$tipo_evaluacion");
        }
        $query = $this->db->query($sql, $parametros);
        return $query->row_array()['num_recomendaciones_aceptadas'] ?? null ;
    }

    public function get_num_recomendaciones_atendidas($dependencia, $periodo, $tipo_evaluacion) {
        $sql = ""
            ."select "
            ."count(*) as num_recomendaciones_atendidas "
            ."from "
            ."actividades a "
            ."left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = dop.id_propuesta_evaluacion "
            ."left join proyectos py on py.id_proyecto = pe.id_proyecto "
            ."where py.cve_dependencia::text LIKE ? "
            ."and a.registro_avance >= a.unidad_medida "
            ."";
        $parametros = array();
        array_push($parametros, "$dependencia");
        if ($periodo > 0) {
            $sql .= ' and py.periodo = ?';
            array_push($parametros, "$periodo");
        }
        if ($tipo_evaluacion > 0) {
            $sql .= ' and pe.id_tipo_evaluacion = ?';
            array_push($parametros, "$tipo_evaluacion");
        }
        $query = $this->db->query($sql, $parametros);
        return $query->row_array()['num_recomendaciones_atendidas'] ?? null ;
    }


    public function guardar($data, $cve_recomendacion)
    {
        if ($cve_recomendacion) {
            $this->db->where('cve_recomendacion', $cve_recomendacion);
            $result = $this->db->update('recomendaciones', $data);
            $id = $cve_recomendacion;
        } else {
            $result = $this->db->insert('recomendaciones', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_recomendacion)
    {
        $this->db->where('cve_recomendacion', $cve_recomendacion);
        $result = $this->db->delete('recomendaciones');
        return $result;
    }

}
