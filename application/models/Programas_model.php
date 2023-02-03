<?php
class Programas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_programa_proyecto($cve_proyecto) {
        $sql = 'select pg.cve_programa, pg.nom_programa from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where py.cve_proyecto = ? ;';
        $query = $this->db->query($sql, array($cve_proyecto));
        return $query->row_array();
    }

}
