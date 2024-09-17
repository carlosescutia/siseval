<?php
class Tipos_actor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_tipos_actor() {
        $sql = 'select * from tipos_actor;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
