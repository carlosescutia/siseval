<?php
class Clasificaciones_supervisor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_clasificaciones_supervisor() {
        $sql = 'select * from clasificaciones_supervisor order by cve_clasificacion_supervisor ;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
