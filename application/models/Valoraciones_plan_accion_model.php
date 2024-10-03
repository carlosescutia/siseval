<?php
class Valoraciones_plan_accion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valoraciones_plan_accion($id_plan_accion) {
        $sql = ''
            .'select  '
            .'vdo.*  '
            .',d.nom_dependencia '
            .'from  '
            .'valoraciones_plan_accion vdo  '
            .'left join dependencias d on d.cve_dependencia = vdo.cve_dependencia '
            .'where  '
            .'vdo.id_plan_accion = ?'
            .'';
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->result_array();
    }

    public function get_valoracion_plan_accion($id_valoracion_plan_accion) {
        $sql = 'select vdo.* from valoraciones_plan_accion vdo where vdo.id_valoracion_plan_accion = ?';
        $query = $this->db->query($sql, array($id_valoracion_plan_accion));
        return $query->row_array();
    }

    public function get_num_valoraciones_plan_accion_dependencia($id_plan_accion, $cve_dependencia) {
        $sql = 'select count(*) as num_valoraciones_plan_accion_dependencia from valoraciones_plan_accion where id_plan_accion = ? and cve_dependencia = ?';
        $query = $this->db->query($sql, array($id_plan_accion, $cve_dependencia));
        return $query->row_array()['num_valoraciones_plan_accion_dependencia'];
    }

    public function get_num_valoraciones_plan_accion($id_plan_accion) {
        $sql = 'select count(*) as num_valoraciones_plan_accion from valoraciones_plan_accion where id_plan_accion = ?';
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['num_valoraciones_plan_accion'];
    }

    public function get_status_valoraciones_plan_accion($id_plan_accion) {
        $sql = "select string_agg(distinct status, '') as status_valoraciones_plan_accion from valoraciones_plan_accion where id_plan_accion = ?";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['status_valoraciones_plan_accion'];
    }

    public function get_observaciones_valoraciones_plan_accion($id_plan_accion) {
        $sql = "select string_agg(observaciones, '') as observaciones_valoraciones_plan_accion from valoraciones_plan_accion where id_plan_accion = ?";
        $query = $this->db->query($sql, array($id_plan_accion));
        return $query->row_array()['observaciones_valoraciones_plan_accion'];
    }

    public function set_status_plan_accion($id_plan_accion, $status)
    {
        $sql = "update valoraciones_plan_accion set status = ? where observaciones <> '' and id_plan_accion = ? ;" ;
        $this->db->query($sql, array($status, $id_plan_accion));
    }

    public function guardar($data, $id_valoracion_plan_accion)
    {
        if ($id_valoracion_plan_accion) {
            $this->db->where('id_valoracion_plan_accion', $id_valoracion_plan_accion);
            $result = $this->db->update('valoraciones_plan_accion', $data);
            $id = $id_valoracion_plan_accion;
        } else {
            $result = $this->db->insert('valoraciones_plan_accion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_valoracion_plan_accion)
    {
        $this->db->where('id_valoracion_plan_accion', $id_valoracion_plan_accion);
        $result = $this->db->delete('valoraciones_plan_accion');
        return $result;
    }

}
