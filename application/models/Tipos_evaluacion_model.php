<?php
class Tipos_evaluacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_tipos_evaluacion() {
        $sql = 'select * from tipos_evaluacion order by orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_tipo_evaluacion($id_tipo_evaluacion) {
        $sql = 'select * from tipos_evaluacion where id_tipo_evaluacion = ?;';
        $query = $this->db->query($sql, array($id_tipo_evaluacion));
        return $query->row_array();
    }

    public function guardar($data, $id_tipo_evaluacion)
    {
        if ($id_tipo_evaluacion) {
            $this->db->where('id_tipo_evaluacion', $id_tipo_evaluacion);
            $this->db->update('tipos_evaluacion', $data);
            $id = $id_tipo_evaluacion;
        } else {
            $this->db->insert('tipos_evaluacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_tipo_evaluacion)
    {
        $this->db->where('id_tipo_evaluacion', $id_tipo_evaluacion);
        $result = $this->db->delete('tipos_evaluacion');
    }

}
