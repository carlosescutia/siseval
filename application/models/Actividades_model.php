<?php
class Actividades_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_actividades_plan_accion($id_plan_accion) {
        $sql = ""
            ."select "
            ." a.* "
            ."from "
            ."actividades a "
            ."left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion "
            ."left join planes_accion pac on pac.cve_documento_opinion = r.cve_documento_opinion "
            ."where "
            ."id_plan_accion = ?"
            ."order by "
            ."a.id_actividad "
            ."";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->result_array();
    }

    public function get_actividad($id_actividad) {
        $sql = ""
            ."select "
            ." a.*, pac.id_plan_accion "
            ."from "
            ."actividades a "
            ."left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion "
            ."left join planes_accion pac on pac.cve_documento_opinion = r.cve_documento_opinion "
            ."where "
            ."id_actividad = ?"
            ."";
        $query = $this->db->query($sql, array($id_actividad));
        return $query->row_array();
    }

    public function get_recomendaciones_tienen_actividad($id_plan_accion) {
        $sql = ""
            ."with actividades_recomendaciones as ( "
            ."select "
            ."r.cve_recomendacion, "
            ."(select "
            ."count(a.id_actividad) "
            ."from "
            ."actividades a "
            ."left join recomendaciones r2 on a.cve_recomendacion = r2.cve_recomendacion "
            ."where "
            ."a.cve_recomendacion = r.cve_recomendacion) as num_actividades "
            ."from "
            ."planes_accion pac "
            ."left join recomendaciones r on r.cve_documento_opinion = pac.cve_documento_opinion "
            ."where "
            ."pac.id_plan_accion = ? "
            ."and r.postura = 'a' "
            .") "
            ."select min(num_actividades) as num_min_actividades from actividades_recomendaciones ";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['num_min_actividades'] ?? null ;
    }

    public function get_ponderacion_actividades_plan_accion($id_plan_accion) {
        $sql = ""
            ."with sum_ponderacion_actividades as ( "
            ."select "
            ."r.cve_recomendacion, sum(a.ponderacion) as ponderacion_actividades "
            ."from "
            ."actividades a "
            ."left join recomendaciones r on r.cve_recomendacion = a.cve_recomendacion "
            ."left join planes_accion pac on pac.cve_documento_opinion = r.cve_documento_opinion "
            ."where "
            ."id_plan_accion = ? "
            ."group by "
            ."r.cve_recomendacion) "
            ."select string_agg(distinct ponderacion_actividades::text, '') as ponderacion_actividades_plan_accion from sum_ponderacion_actividades "
            ."";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['ponderacion_actividades_plan_accion'] ?? null ;
    }

    public function guardar($data, $id_actividad)
    {
        if ($id_actividad) {
            $this->db->where('id_actividad', $id_actividad);
            $result = $this->db->update('actividades', $data);
            $id = $id_actividad;
        } else {
            $result = $this->db->insert('actividades', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_actividad)
    {
        $this->db->where('id_actividad', $id_actividad);
        $result = $this->db->delete('actividades');
        return $result;
    }

}
