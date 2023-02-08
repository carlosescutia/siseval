<?php
class Evaluaciones_actuales_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_evaluacion_actual($id_evaluacion_actual) {
        $sql = 'select * from evaluaciones_actuales where id_evaluacion_actual = ?;';
        $query = $this->db->query($sql, array($id_evaluacion_actual));
        return $query->row_array();
    }

    public function get_evaluacion_actual_proyecto($cve_proyecto) {
        $sql = 'select * from evaluaciones_actuales where cve_proyecto = ?;';
        $query = $this->db->query($sql, array($cve_proyecto));
        return $query->row_array();
    }

    public function guardar($data, $id_evaluacion_actual)
    {
        if ($id_evaluacion_actual) {
            $this->db->where('id_evaluacion_actual', $id_evaluacion_actual);
            $this->db->update('evaluaciones_actuales', $data);
            $id = $id_evaluacion_actual;
        } else {
            $this->db->insert('evaluaciones_actuales', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_evaluacion_actual)
    {
        $this->db->where('id_evaluacion_actual', $id_evaluacion_actual);
        $result = $this->db->delete('evaluaciones_actuales');
    }

}
