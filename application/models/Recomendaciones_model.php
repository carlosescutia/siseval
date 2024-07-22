<?php
class Recomendaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_recomendaciones() {
        $sql = 'select * from recomendaciones order by cve_recomendacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_recomendaciones_doc_op($cve_documento_opinion) {
        $sql = 'select * from recomendaciones where cve_documento_opinion = ? order by cve_recomendacion;';
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->result_array();
    }

    public function get_recomendacion($cve_recomendacion) {
        $sql = 'select * from recomendaciones where cve_recomendacion = ?;';
        $query = $this->db->query($sql, array($cve_recomendacion));
        return $query->row_array();
    }

    public function guardar($data, $cve_recomendacion)
    {
        if ($cve_recomendacion) {
            $this->db->where('cve_recomendacion', $cve_recomendacion);
            $result = $this->db->update('recomendaciones', $data);
            $id = $cve_recomendacion;
        } else {
            $result = $this->db->insert('recomendaciones', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_recomendacion)
    {
        $this->db->where('cve_recomendacion', $cve_recomendacion);
        $result = $this->db->delete('recomendaciones');
        return $result;
    }

}
