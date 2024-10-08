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

    public function get_opciones_sistema_otorgables() {
        $sql = 'select * from opciones_sistema where otorgable = 1 order by cod_opcion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_opcion($cve_opcion) {
        $sql = 'select * from opciones_sistema where cve_opcion = ?;';
        $query = $this->db->query($sql, array($cve_opcion));
        return $query->row_array();
    }

    public function get_opcion_cod($cod_opcion) {
        $sql = 'select * from opciones_sistema where cod_opcion = ?;';
        $query = $this->db->query($sql, array($cod_opcion));
        return $query->row_array();
    }

    public function guardar($data, $cve_opcion)
    {
        if ($cve_opcion) {
            $this->db->where('cve_opcion', $cve_opcion);
            $this->db->update('opciones_sistema', $data);
            $id = $cve_opcion;
        } else {
            $this->db->insert('opciones_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_opcion)
    {
        $this->db->where('cve_opcion', $cve_opcion);
        $result = $this->db->delete('opciones_sistema');
        return $result;
    }

}
