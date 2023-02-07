<?php
class Justificaciones_evaluacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_justificaciones_evaluacion() {
        $sql = 'select * from justificaciones_evaluacion order by id_justificacion_evaluacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_justificacion_evaluacion($id_justificacion_evaluacion) {
        $sql = 'select * from justificaciones_evaluacion where id_justificacion_evaluacion = ?;';
        $query = $this->db->query($sql, array($id_justificacion_evaluacion));
        return $query->row_array();
    }

    public function guardar($data, $id_justificacion_evaluacion)
    {
        if ($id_justificacion_evaluacion) {
            $this->db->where('id_justificacion_evaluacion', $id_justificacion_evaluacion);
            $this->db->update('justificaciones_evaluacion', $data);
            $id = $id_justificacion_evaluacion;
        } else {
            $this->db->insert('justificaciones_evaluacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_justificacion_evaluacion)
    {
        $this->db->where('id_justificacion_evaluacion', $id_justificacion_evaluacion);
        $result = $this->db->delete('justificaciones_evaluacion');
    }

}
