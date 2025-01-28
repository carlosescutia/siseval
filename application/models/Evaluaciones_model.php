<?php
class Evaluaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_evaluaciones_proyecto($cve_proyecto, $periodo) {
        $sql = 'select e.* from evaluaciones e where e.cve_proyecto = ? and e.periodo < ? order by e.periodo, e.dependencia_responsable, e.tipo_evaluacion';
        $query = $this->db->query($sql, array($cve_proyecto, $periodo));
        return $query->result_array();
    }

    public function get_evaluacion($id_evaluacion, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' or $cve_rol == 'sup' or $cve_rol == 'sec') {
            $cve_dependencia = '%';
        }
        $sql = 'select e.* from evaluaciones e left join proyectos py on e.cve_proyecto = py.cve_anterior_proyecto left join programas pg on py.cve_programa = pg.cve_programa where e.id_evaluacion = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($id_evaluacion, $cve_dependencia));
        return $query->row_array();
    }

}
