<?php
class Eventos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_eventos($periodo) {
        $sql = 'select * from eventos where extract(year from fecha_evento) = ? order by id_evento;';
        $query = $this->db->query($sql, array($periodo));
        return $query->result_array();
    }

    public function get_evento($id_evento) {
        $sql = 'select * from eventos where id_evento = ?;';
        $query = $this->db->query($sql, array($id_evento));
        return $query->row_array();
    }

    public function guardar($data, $id_evento)
    {
        if ($id_evento) {
            $this->db->where('id_evento', $id_evento);
            $result = $this->db->update('eventos', $data);
            $id = $id_evento;
        } else {
            $result = $this->db->insert('eventos', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_evento)
    {
        $this->db->where('id_evento', $id_evento);
        $result = $this->db->delete('eventos');
        return $result;
    }

}
