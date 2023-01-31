<?php
class Dependencias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_dependencias() {
        $sql = 'select * from dependencias order by cve_dependencia;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_dependencia($cve_dependencia) {
        $sql = 'select * from dependencias where cve_dependencia = ?;';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->row_array();
    }

    public function guardar($data, $cve_dependencia)
    {
        if ($cve_dependencia) {
            $this->db->where('cve_dependencia', $cve_dependencia);
            $this->db->update('dependencias', $data);
            $id = $cve_dependencia;
        } else {
            $this->db->insert('dependencias', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_dependencia)
    {
        $this->db->where('cve_dependencia', $cve_dependencia);
        $result = $this->db->delete('dependencias');
    }

}
