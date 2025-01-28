<?php
class Criterios_calificacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_criterios_calificacion() {
        $sql = 'select * from criterios_calificacion order by id_criterio_calificacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_criterio_calificacion($id_criterio_calificacion) {
        $sql = 'select * from criterios_calificacion where id_criterio_calificacion = ?;';
        $query = $this->db->query($sql, array($id_criterio_calificacion));
        return $query->row_array();
    }

    public function guardar($data, $id_criterio_calificacion)
    {
        if ($id_criterio_calificacion) {
            $this->db->where('id_criterio_calificacion', $id_criterio_calificacion);
            $result = $this->db->update('criterios_calificacion', $data);
            $id = $id_criterio_calificacion;
        } else {
            $result = $this->db->insert('criterios_calificacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_criterio_calificacion)
    {
        $this->db->where('id_criterio_calificacion', $id_criterio_calificacion);
        $result = $this->db->delete('criterios_calificacion');
        return $result;
    }

}
