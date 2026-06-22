<?php
class Evaluaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_evaluaciones_proyecto($id_proyecto, $periodo) {
        //$sql = 'select e.* from evaluaciones e where e.cve_proyecto = ? and e.periodo < ? order by e.periodo, e.dependencia_responsable, e.tipo_evaluacion';
        $sql = ""
            ."select "
            ."e.* "
            ."from "
            ."evaluaciones e "
            ."where "
            ."cve_proyecto in "
            ."(select "
            ."cve_proyecto "
            ."from "
            ."proyectos "
            ."where "
            ."id_proyecto = ? "
            ."union "
            ."select "
            ."pa.cve_proyecto_anterior "
            ."from "
            ."proyectos_anteriores pa "
            ."left join proyectos py on py.cve_proyecto = pa.cve_proyecto "
            ."where "
            ."py.id_proyecto = ?)"
            ."and e.periodo < ? order by e.periodo, e.dependencia_responsable, e.tipo_evaluacion "
            ."";
        $query = $this->db->query($sql, array($id_proyecto, $id_proyecto, $periodo));
        return $query->result_array();
    }

    public function get_evaluacion($id_evaluacion, $cve_dependencia, $cve_rol, $periodo) {
        if ($cve_rol != 'usr') {
            $cve_dependencia = '%';
        }
        $sql = ""
            ."select "
            ."e.*, py.id_proyecto, py.cve_proyecto "
            ."from "
            ."evaluaciones e "
            ."left join proyectos py on py.cve_proyecto in  "
            ."(select cve_proyecto from proyectos_anteriores where cve_proyecto = (select cve_proyecto from evaluaciones where id_evaluacion = e.id_evaluacion) "
            ."union  "
            ."select cve_proyecto from proyectos_anteriores where cve_proyecto_anterior = (select cve_proyecto from evaluaciones where id_evaluacion = e.id_evaluacion)  "
            .") and py.periodo = ? "
            ."where "
            ."e.id_evaluacion = ? "
            ."and py.cve_dependencia::text LIKE ? "
            ."";
        $query = $this->db->query($sql, array($periodo, $id_evaluacion, $cve_dependencia));
        return $query->row_array();
    }

}
