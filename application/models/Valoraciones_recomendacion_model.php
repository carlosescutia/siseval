<?php
class Valoraciones_recomendacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valoraciones_recomendacion_documento_opinion($cve_documento_opinion) {
        $sql = ""
            ."select "
            ."vr.*, d.nom_dependencia "
            ."from "
            ."valoraciones_recomendacion vr "
            ."left join recomendaciones r on r.cve_recomendacion = vr.cve_recomendacion "
            ."left join documentos_opinion dop on dop.cve_documento_opinion = r.cve_documento_opinion "
            ."left join dependencias d on d.cve_dependencia = vr.cve_dependencia "
            ."where "
            ."dop.cve_documento_opinion = ? "
            ."";

        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->result_array();
    }

    public function get_valoracion_recomendacion($cve_valoracion_recomendacion) {
        $sql = 'select vdo.*, r.cve_documento_opinion from valoraciones_recomendacion vdo left join recomendaciones r on r.cve_recomendacion = vdo.cve_recomendacion where vdo.cve_valoracion_recomendacion = ?';
        $query = $this->db->query($sql, array($cve_valoracion_recomendacion));
        return $query->row_array();
    }

    public function get_num_valoraciones_documento_opinion($cve_documento_opinion) {
        $sql = ""
            ."select "
            ."count(*) as num_valoraciones_documento_opinion "
            ."from "
            ."valoraciones_recomendacion vr "
            ."left join "
            ."recomendaciones r on r.cve_recomendacion = vr.cve_recomendacion "
            ."where "
            ."r.cve_documento_opinion = ? "
            ."";
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->row_array()['num_valoraciones_documento_opinion'];
    }

    public function get_num_valoraciones_recomendacion($cve_recomendacion) {
        $sql = ""
            ."select "
            ."count(*) as num_valoraciones_recomendacion "
            ."from "
            ."valoraciones_recomendacion vr "
            ."left join "
            ."recomendaciones r on r.cve_recomendacion = vr.cve_recomendacion "
            ."where "
            ."r.cve_recomendacion = ? "
            ."";
        $query = $this->db->query($sql, array($cve_recomendacion));
        return $query->row_array()['num_valoraciones_recomendacion'];
    }

    public function get_status_valoraciones_documento_opinion($cve_documento_opinion) {
        $sql = ""
            ."select "
            ."string_agg(distinct vr.status, '') as status_valoraciones_documento_opinion "
            ."from "
            ."valoraciones_recomendacion vr "
            ."left join "
            ."recomendaciones r on r.cve_recomendacion = vr.cve_recomendacion "
            ."where "
            ."r.cve_documento_opinion = ? "
            ."";
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->row_array()['status_valoraciones_documento_opinion'];
    }

    public function get_observaciones_valoraciones_documento_opinion($cve_documento_opinion) {
        $sql = ""
            ."select "
            ."string_agg(observaciones, '') as observaciones_valoraciones_documento_opinion "
            ."from "
            ."valoraciones_recomendacion vr "
            ."left join "
            ."recomendaciones r on r.cve_recomendacion = vr.cve_recomendacion "
            ."where "
            ."r.cve_documento_opinion = ? "
            ."";
        $query = $this->db->query($sql, array($cve_documento_opinion));
        return $query->row_array()['observaciones_valoraciones_documento_opinion'];
    }

    public function set_status_documento_opinion($cve_documento_opinion, $status)
    {
        $sql = "update valoraciones_recomendacion vr set status = ? from recomendaciones r where r.cve_recomendacion = vr.cve_recomendacion and vr.observaciones <> '' and r.cve_documento_opinion = ?" ;
        $this->db->query($sql, array($status, $cve_documento_opinion));
    }

    public function guardar($data, $cve_valoracion_recomendacion)
    {
        if ($cve_valoracion_recomendacion) {
            $this->db->where('cve_valoracion_recomendacion', $cve_valoracion_recomendacion);
            $result = $this->db->update('valoraciones_recomendacion', $data);
            $id = $cve_valoracion_recomendacion;
        } else {
            $result = $this->db->insert('valoraciones_recomendacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_valoracion_recomendacion)
    {
        $this->db->where('cve_valoracion_recomendacion', $cve_valoracion_recomendacion);
        $result = $this->db->delete('valoraciones_recomendacion');
        return $result;
    }

}
