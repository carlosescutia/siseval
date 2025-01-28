<?php
class Nocarga_evaluaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_nocarga_evaluaciones() {
        $sql = 'select * from nocarga_evaluaciones order by id_nocarga_evaluacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_nocarga_evaluacion($id_nocarga_evaluacion) {
        $sql = 'select * from nocarga_evaluaciones where id_nocarga_evaluacion = ?;';
        $query = $this->db->query($sql, array($id_nocarga_evaluacion));
        return $query->row_array();
    }

    public function guardar($data)
    {
        $result = $this->db->insert('nocarga_evaluaciones', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function eliminar($data)
    {
        $this->db->where('cve_dependencia', $data['cve_dependencia']);
        $this->db->where('periodo', $data['periodo']);
        $result = $this->db->delete('nocarga_evaluaciones');
        return $result;
    }

}
