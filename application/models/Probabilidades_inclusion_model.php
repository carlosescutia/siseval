<?php
class Probabilidades_inclusion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_probabilidades_inclusion() {
        $sql = 'select * from probabilidades_inclusion order by orden';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
