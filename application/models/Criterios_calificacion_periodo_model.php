<?php
class Criterios_calificacion_periodo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_criterios_calificacion_periodo($periodo) {
        $sql = 'select * from criterios_calificacion_periodo where periodo = ? order by id_criterio_calificacion_periodo ';
        $query = $this->db->query($sql, array($periodo));
        return $query->result_array();
    }

    public function get_criterio_calificacion_periodo($id_criterio_calificacion_periodo) {
        $sql = 'select * from criterios_calificacion_periodo where id_criterio_calificacion_periodo = ?;';
        $query = $this->db->query($sql, array($id_criterio_calificacion_periodo));
        return $query->row_array();
    }

    public function guardar($data, $id_criterio_calificacion_periodo)
    {
        if ($id_criterio_calificacion_periodo) {
            $this->db->where('id_criterio_calificacion_periodo', $id_criterio_calificacion_periodo);
            $result = $this->db->update('criterios_calificacion_periodo', $data);
            $id = $id_criterio_calificacion_periodo;
        } else {
            $result = $this->db->insert('criterios_calificacion_periodo', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_criterio_calificacion_periodo)
    {
        $this->db->where('id_criterio_calificacion_periodo', $id_criterio_calificacion_periodo);
        $result = $this->db->delete('criterios_calificacion_periodo');
        return $result;
    }

}

