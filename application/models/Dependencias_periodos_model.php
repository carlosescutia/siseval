<?php
class Dependencias_periodos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    public function get_dependencias_periodos() {
        $sql = 'select * from dependencias_periodos order by cve_dependencia';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_dependencia_periodo($id_dependencia_periodo) {
        $sql = 'select * from dependencias_periodos where id_dependencia_periodo = ? ';
        $query = $this->db->query($sql, array($id_dependencia_periodo));
        return $query->row_array();
    }

    public function get_dependencia_periodo_dependencia($cve_dependencia) {
        $sql = 'select * from dependencias_periodos where cve_dependencia = ? order by periodo desc';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    /* revisar */
    public function guardar($data, $id_dependencia_periodo)
    {
        if ($id_dependencia_periodo) {
            $this->db->where('id_dependencia_periodo', $id_dependencia_periodo);
            $this->db->update('dependencias_periodos', $data);
            $id = $id_dependencia_periodo;
        } else {
            $this->db->insert('dependencias_periodos', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_dependencia_periodo)
    {
        $this->db->where('id_dependencia_periodo', $id_dependencia_periodo);
        $result = $this->db->delete('dependencias_periodos');
    }

}
