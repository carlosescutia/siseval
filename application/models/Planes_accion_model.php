<?php
class Planes_accion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_planes_accion() {
        $sql = 'select * from planes_accion order by id_plan_accion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_plan_accion($id_plan_accion) {
        $sql = 'select pa.* from planes_accion pa where pa.id_plan_accion = ?;';
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array();
    }

    public function get_plan_accion_actividad($id_actividad) {
        $sql = ""
            ."select "
            ."pac.* "
            ."from "
            ."planes_accion pac "
            ."left join recomendaciones r on r.cve_documento_opinion = pac.cve_documento_opinion "
            ."left join actividades a on a.cve_recomendacion = r.cve_recomendacion "
            ."where "
            ."a.id_actividad = ? "
            ."";
        $query = $this->db->query($sql, array($id_actividad));
        return $query->row_array();
    }

    public function guardar($data, $id_plan_accion)
    {
        if ($id_plan_accion) {
            $this->db->where('id_plan_accion', $id_plan_accion);
            $result = $this->db->update('planes_accion', $data);
            $id = $id_plan_accion;
        } else {
            $result = $this->db->insert('planes_accion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_plan_accion)
    {
        $this->db->where('id_plan_accion', $id_plan_accion);
        $result = $this->db->delete('planes_accion');
        return $result;
    }

}
