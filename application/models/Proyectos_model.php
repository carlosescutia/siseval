<?php
class Proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_proyectos_dependencia($cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' || $cve_rol == 'sup') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.*, pg.* from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where pg.cve_dependencia::text LIKE ? order by pg.cve_programa, py.cve_proyecto;';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    public function get_proyecto($cve_proyecto, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' || $cve_rol == 'sup') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.* from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where py.cve_proyecto = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($cve_proyecto, $cve_dependencia));
        return $query->row_array();
    }

    public function get_proyecto_anterior($cve_anterior_proyecto, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' || $cve_rol == 'sup') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.* from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where py.cve_anterior_proyecto = ? and pg.cve_dependencia::text LIKE ?';
        $query = $this->db->query($sql, array($cve_anterior_proyecto, $cve_dependencia));
        return $query->row_array();
    }

}
