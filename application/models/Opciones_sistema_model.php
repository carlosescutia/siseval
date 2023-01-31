<?php
class Opciones_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_opciones_sistema() {
        $sql = 'select * from opciones_sistema order by cod_opcion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_opcion($cve_opcion) {
        $sql = 'select * from opciones_sistema where cve_opcion = ?;';
        $query = $this->db->query($sql, array($cve_opcion));
        return $query->row_array();
    }

    public function guardar($data, $cve_opcion)
    {
        if ($cve_opcion) {
            $this->db->where('cve_opcion', $cve_opcion);
            $result = $this->db->update('opciones_sistema', $data);
        } else {
            $result = $this->db->insert('opciones_sistema', $data);
        }
        return $result;
    }

    public function eliminar($cve_opcion)
    {
        $this->db->where('cve_opcion', $cve_opcion);
        $result = $this->db->delete('opciones_sistema');
        return $result;
    }

}
