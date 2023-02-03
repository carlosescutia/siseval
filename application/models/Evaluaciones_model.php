<?php
class Evaluaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_evaluaciones_proyecto($cve_proyecto) {
        $sql = 'select e.* from evaluaciones e where e.cve_proyecto = ?';
        $query = $this->db->query($sql, array($cve_proyecto));
        return $query->result_array();
    }

    public function get_evaluacion($id_evaluacion, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' || $cve_rol == 'sup') {
            $cve_dependencia = '%';
        }
        $sql = 'select e.* from evaluaciones e left join proyectos py on e.cve_proyecto = py.cve_anterior_proyecto left join programas pg on py.cve_programa = pg.cve_programa where e.id_evaluacion = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($id_evaluacion, $cve_dependencia));
        return $query->row_array();
    }

}
