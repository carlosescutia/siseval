<?php
class Valoraciones_documento_opinion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valoraciones_documento_opinion($cve_documento_opinion) {
        $sql = ''
            .'select  '
            .'vdo.*  '
            .',d.nom_dependencia '
            .'from  '
            .'valoraciones_documento_opinion vdo  '
            .'left join dependencias d on d.cve_dependencia = vdo.cve_dependencia '
            .'where  '
            .'vdo.cve_documento_opinion = ?'
            .'';
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->result_array();
    }

    public function get_valoracion_documento_opinion($cve_valoracion_documento_opinion) {
        $sql = 'select vdo.* from valoraciones_documento_opinion vdo where vdo.cve_valoracion_documento_opinion = ?';
        $query = $this->db->query($sql, array($cve_valoracion_documento_opinion));
        return $query->row_array();
    }

    public function get_num_valoraciones_documento_opinion($cve_documento_opinion, $cve_dependencia) {
        $sql = 'select count(*) as num from valoraciones_documento_opinion where cve_documento_opinion = ? and cve_dependencia = ?';
        $query = $this->db->query($sql, array($cve_documento_opinion, $cve_dependencia));
        return $query->row_array();
    }

    public function guardar($data, $cve_valoracion_documento_opinion)
    {
        if ($cve_valoracion_documento_opinion) {
            $this->db->where('cve_valoracion_documento_opinion', $cve_valoracion_documento_opinion);
            $result = $this->db->update('valoraciones_documento_opinion', $data);
            $id = $cve_valoracion_documento_opinion;
        } else {
            $result = $this->db->insert('valoraciones_documento_opinion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_valoracion_documento_opinion)
    {
        $this->db->where('cve_valoracion_documento_opinion', $cve_valoracion_documento_opinion);
        $result = $this->db->delete('valoraciones_documento_opinion');
        return $result;
    }

}

