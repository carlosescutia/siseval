<?php
class Documentos_opinion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_documentos_opinion() {
        $sql = 'select * from documentos_opinion order by cve_documento_opinion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_documento_opinion($cve_documento_opinion) {
        $sql = 'select dop.*, sdop.desc_status_documento_opinion, (select count(cve_recomendacion) from recomendaciones r where r.cve_documento_opinion = dop.cve_documento_opinion) as num_recomendaciones from documentos_opinion dop left join status_documentos_opinion sdop on sdop.cve_status_documento_opinion = dop.status where dop.cve_documento_opinion = ?;';
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->row_array();
    }

    public function guardar($data, $cve_documento_opinion)
    {
        if ($cve_documento_opinion) {
            $this->db->where('cve_documento_opinion', $cve_documento_opinion);
            $result = $this->db->update('documentos_opinion', $data);
            $id = $cve_documento_opinion;
        } else {
            $result = $this->db->insert('documentos_opinion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_documento_opinion)
    {
        $this->db->where('cve_documento_opinion', $cve_documento_opinion);
        $result = $this->db->delete('documentos_opinion');
        return $result;
    }

}
