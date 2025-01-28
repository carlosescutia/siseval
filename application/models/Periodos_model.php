<?php
class Periodos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_periodos() {
        $sql = 'select * from periodos order by nom_periodo desc;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_periodo($id_periodo) {
        $sql = 'select * from periodos where id_periodo = ?;';
        $query = $this->db->query($sql, array($id_periodo));
        return $query->row_array();
    }

    public function get_periodo_nom_periodo($nom_periodo) {
        $sql = 'select * from periodos where nom_periodo = ?;';
        $query = $this->db->query($sql, array($nom_periodo));
        return $query->row_array();
    }

    public function guardar($data, $id_periodo)
    {
        if ($id_periodo) {
            $this->db->where('id_periodo', $id_periodo);
            $result = $this->db->update('periodos', $data);
            $id = $id_periodo;
        } else {
            $result = $this->db->insert('periodos', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_periodo)
    {
        $this->db->where('id_periodo', $id_periodo);
        $result = $this->db->delete('periodos');
        return $result;
    }

}
