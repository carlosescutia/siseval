<?php
class Semaforo_proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_semaforo_proyecto($cve_proyecto, $periodo) {
        $sql = 'select * from semaforo_proyectos where cve_proyecto = ? and periodo = ?  ';
        $query = $this->db->query($sql, array($cve_proyecto, $periodo));
        return $query->row_array();
    }

}
