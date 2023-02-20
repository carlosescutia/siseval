<?php
class Proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_proyectos_dependencia($cve_dependencia, $anexo_social, $evaluaciones_propuestas) {
        $sql = "select py.*, pg.*, (select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) as status_actual, (select count(*) from evaluaciones ev left join proyectos pry on ev.cve_proyecto = pry.cve_anterior_proyecto where pry.cve_proyecto = py.cve_proyecto) as status_previo from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where pg.cve_dependencia::text LIKE ? ";

        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        if ($anexo_social > 0) {
            $sql .= ' and py.anexo_social = ?';
            array_push($parametros, "$anexo_social");
        }
        if ($evaluaciones_propuestas == '1') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) > 0';
        }
        if ($evaluaciones_propuestas == '2') {
            $sql .= ' and (select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) = 0';
        }
        $sql .= ' order by pg.cve_programa, py.cve_proyecto;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_proyecto($cve_proyecto, $cve_dependencia, $cve_rol) {
        if ($cve_rol == 'adm' || $cve_rol == 'sup') {
            $cve_dependencia = '%';
        }
        $sql = 'select py.*, d.nom_dependencia from proyectos py left join programas pg on py.cve_programa = pg.cve_programa left join dependencias d on pg.cve_dependencia = d.cve_dependencia where py.cve_proyecto = ? and pg.cve_dependencia::text LIKE ?';
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

    public function get_programas_agenda_evaluacion() {
        $sql = 'select d.nom_dependencia, pg.cve_programa, pg.nom_programa as nom_programa, pcp.cve_proyecto, py.nom_proyecto as nom_proyecto, pcp.nom_tipo_evaluacion from puntaje_calificacion_propuesta pcp left join proyectos py on pcp.cve_proyecto = py.cve_proyecto left join programas pg on py.cve_programa = pg.cve_programa left join dependencias d on d.cve_dependencia = pg.cve_dependencia where pcp.puntaje >= 200 ;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
