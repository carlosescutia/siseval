<?php
class Tipos_evaluacion_periodo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_tipos_evaluacion_periodo($periodo) {
        $sql = ''
            .'select '
            .'tep.*, te.nom_tipo_evaluacion '
            .'from '
            .'tipos_evaluacion_periodo tep '
            .'left join tipos_evaluacion te on te.id_tipo_evaluacion = tep.id_tipo_evaluacion '
            .'where '
            .'tep.periodo = ? '
            .'order by '
            .'tep.periodo desc'
            .'';
        $query = $this->db->query($sql, array($periodo));
        return $query->result_array();
    }

    public function get_id_tipos_evaluacion_periodo($periodo) {
        $sql = ""
            ."select "
            ."string_agg(tep.id_tipo_evaluacion::text, ',') as id_tipo_evaluacion "
            ."from "
            ."tipos_evaluacion_periodo tep "
            ."left join tipos_evaluacion te on te.id_tipo_evaluacion = tep.id_tipo_evaluacion "
            ."where "
            ."tep.periodo = ? "
            ."group by "
            ."tep.periodo "
            ."order by "
            ."tep.periodo desc"
            ."";
        $query = $this->db->query($sql, array($periodo));
        return $query->row_array()['id_tipo_evaluacion'] ?? null ;

    }

    public function get_tipo_evaluacion_periodo($id_tipo_evaluacion_periodo) {
        $sql = 'select * from tipos_evaluacion_periodo where id_tipo_evaluacion_periodo = ?;';
        $query = $this->db->query($sql, array($id_tipo_evaluacion_periodo));
        return $query->row_array();
    }

    public function guardar($data)
    {
        $result = $this->db->insert('tipos_evaluacion_periodo', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function eliminar($id_tipo_evaluacion_periodo)
    {
        $this->db->where('id_tipo_evaluacion_periodo', $id_tipo_evaluacion_periodo);
        $result = $this->db->delete('tipos_evaluacion_periodo');
        return $result;
    }

}

