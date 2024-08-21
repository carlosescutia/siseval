<?php
class Status_documentos_opinion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_status_documentos_opinion() {
        $sql = 'select * from status_documentos_opinion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_status_documento_opinion($cve_status_documento_opinion) {
        $sql = 'select * from status_documentos_opinion where cve_status_documento_opinion = ?;';
        $query = $this->db->query($sql, array($cve_status_documento_opinion));
        return $query->row_array();
    }

    public function guardar($data, $cve_status_documento_opinion)
    {
        if ($cve_status_documento_opinion) {
            $this->db->where('cve_status_documento_opinion', $cve_status_documento_opinion);
            $result = $this->db->update('status_documentos_opinion', $data);
            $id = $cve_status_documento_opinion;
        } else {
            $result = $this->db->insert('status_documentos_opinion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_status_documento_opinion)
    {
        $this->db->where('cve_status_documento_opinion', $cve_status_documento_opinion);
        $result = $this->db->delete('status_documentos_opinion');
        return $result;
    }

}
