<?php
class Valores_calificacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valores_calificacion() {
        $sql = 'select * from valores_calificacion order by orden;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
