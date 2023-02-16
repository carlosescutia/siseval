<?php
class Calificaciones_propuesta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_calificaciones_propuesta_propuesta_evaluacion($id_propuesta_evaluacion) {
        $sql = 'select * from puntaje_calificacion_dependencia where id_propuesta_evaluacion = ?';
        $query = $this->db->query($sql, array($id_propuesta_evaluacion));
        return $query->result_array();
    }

    public function get_calificacion_final_propuesta_evaluacion($id_propuesta_evaluacion) {
        $sql = 'select * from puntaje_calificacion_propuesta where id_propuesta_evaluacion = ?';
        $query = $this->db->query($sql, array($id_propuesta_evaluacion));
        return $query->row_array();
    }

    public function get_calificacion_propuesta($id_calificacion_propuesta) {
        $sql = 'select cp.*, pcd.puntaje, d.cve_dependencia, d.nom_dependencia from calificaciones_propuesta cp left join dependencias d on cp.cve_dependencia = d.cve_dependencia left join puntaje_calificacion_dependencia pcd on pcd.id_calificacion_propuesta = cp.id_calificacion_propuesta where cp.id_calificacion_propuesta = ?';
        $query = $this->db->query($sql, array($id_calificacion_propuesta));
        return $query->row_array();
    }

    public function get_num_calificaciones_propuesta_dependencia($id_propuesta_evaluacion, $cve_dependencia) {
        $sql = 'select count(*) as num from calificaciones_propuesta where id_propuesta_evaluacion = ? and cve_dependencia = ? ;';
        $query = $this->db->query($sql, array($id_propuesta_evaluacion, $cve_dependencia));
        return $query->row_array();
    }

    public function guardar($data, $id_calificacion_propuesta)
    {
        if ($id_calificacion_propuesta) {
            $this->db->where('id_calificacion_propuesta', $id_calificacion_propuesta);
            $this->db->update('calificaciones_propuesta', $data);
            $id = $id_calificacion_propuesta;
        } else {
            $this->db->insert('calificaciones_propuesta', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_calificacion_propuesta)
    {
        $this->db->where('id_calificacion_propuesta', $id_calificacion_propuesta);
        $result = $this->db->delete('calificaciones_propuesta');
    }

}
