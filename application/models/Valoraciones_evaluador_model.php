<?php
class Valoraciones_evaluador_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valoraciones_evaluador() {
        $sql = 'select * from valoraciones_evaluador order by id_valoracion_evaluador;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_valoracion_evaluador($id_valoracion_evaluador) {
        $sql = 'select * from valoraciones_evaluador where id_valoracion_evaluador = ?;';
        $sql = ""
            ."select  "
            ."ver.*, pe.cve_proyecto, py.nom_proyecto, "
            ."(ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as puntaje_valoracion_evaluador "
            ."from valoraciones_evaluador ver  "
            ."left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = ver.id_propuesta_evaluacion  "
            ."left join proyectos py on py.cve_proyecto = pe.cve_proyecto  "
            ."where ver.id_valoracion_evaluador = ? "
            ."";
        $query = $this->db->query($sql, array($id_valoracion_evaluador));
        return $query->row_array();
    }

    public function guardar($data, $id_valoracion_evaluador)
    {
        if ($id_valoracion_evaluador) {
            $this->db->where('id_valoracion_evaluador', $id_valoracion_evaluador);
            $result = $this->db->update('valoraciones_evaluador', $data);
            $id = $id_valoracion_evaluador;
        } else {
            $result = $this->db->insert('valoraciones_evaluador', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_valoracion_evaluador)
    {
        $this->db->where('id_valoracion_evaluador', $id_valoracion_evaluador);
        $result = $this->db->delete('valoraciones_evaluador');
        return $result;
    }

}
