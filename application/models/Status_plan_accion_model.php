<?php
class Status_plan_accion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_status_plan_accion_all() {
        $sql = 'select * from status_plan_accion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_status_plan_accion($cve_status_plan_accion) {
        $sql = 'select * from status_plan_accion where cve_status_plan_accion = ?;';
        $query = $this->db->query($sql, array($cve_status_plan_accion));
        return $query->row_array();
    }

    public function guardar($data, $cve_status_plan_accion)
    {
        if ($cve_status_plan_accion) {
            $this->db->where('cve_status_plan_accion', $cve_status_plan_accion);
            $result = $this->db->update('status_plan_accion', $data);
            $id = $cve_status_plan_accion;
        } else {
            $result = $this->db->insert('status_plan_accion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_status_plan_accion)
    {
        $this->db->where('cve_status_plan_accion', $cve_status_plan_accion);
        $result = $this->db->delete('status_plan_accion');
        return $result;
    }

}
