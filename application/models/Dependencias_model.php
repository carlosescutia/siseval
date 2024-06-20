<?php
class Dependencias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_dependencias() {
        $sql = 'select * from dependencias order by cve_dependencia;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_dependencia($cve_dependencia) {
        $sql = 'select * from dependencias where cve_dependencia = ?;';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->row_array();
    }

    public function get_dependencias_proyectos($cve_dependencia, $anexo_social, $evaluaciones_propuestas) {
        $sql = ''
			.'select  '
			.'py.cve_dependencia, d.nom_dependencia, d.carga_evaluaciones, '
			.'count(*) as num_proyectos '
			.'from  '
			.'proyectos py  '
			.'left join dependencias d on py.cve_dependencia = d.cve_dependencia  '
			.'where  '
			.'py.cve_dependencia::text LIKE ?  '
			.'';
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
		$sql .= ' group by py.cve_dependencia, d.nom_dependencia, d.carga_evaluaciones  ';
        $sql .= ' order by py.cve_dependencia;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_dependencias_evaluaciones($cve_dependencia) {
        $sql = ""
            ."select  "
            ."dpe.cve_dependencia, dpe.nom_dependencia  "
            ."from  "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on py.cve_proyecto = pe.cve_proyecto "
            ."left join dependencias dpe on py.cve_dependencia = dpe.cve_dependencia "
            ."where  "
            ."dpe.cve_dependencia::text LIKE ? "
			."";
        $parametros = array();
        array_push($parametros, "$cve_dependencia");
		$sql .= ' group by dpe.cve_dependencia, dpe.nom_dependencia ';
        $sql .= ' order by dpe.cve_dependencia;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_status_dependencias($evaluaciones, $propuestas) {
        $sql = ""
            ."select  "
            ."d.cve_dependencia, d.nom_dependencia,  "
            ."d.nom_completo_dependencia, "
            ."(case when d.carga_evaluaciones = 1 then 'si' else 'no' end) as solicita_evaluaciones, "
            ."(select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.cve_proyecto = py.cve_proyecto where py.cve_dependencia = d.cve_dependencia) as num_propuestas "
            ."from  "
            ."dependencias d "
            ."where "
            ."true "
            ."";
        $parametros = array();
        if ($evaluaciones <> "") {
            $sql .= "and d.carga_evaluaciones = ? ";
            array_push($parametros, "$evaluaciones");
        } 
        if ($propuestas == '0') {
            $sql .= "and (select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.cve_proyecto = py.cve_proyecto where py.cve_dependencia = d.cve_dependencia) = 0";
        } 
        if ($propuestas > '0') {
            $sql .= "and (select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.cve_proyecto = py.cve_proyecto where py.cve_dependencia = d.cve_dependencia) > 0";
        } 
        $sql .= ' order by d.nom_dependencia;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function guardar($data, $cve_dependencia)
    {
        if ($cve_dependencia) {
            $this->db->where('cve_dependencia', $cve_dependencia);
            $this->db->update('dependencias', $data);
            $id = $cve_dependencia;
        } else {
            $this->db->insert('dependencias', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_dependencia)
    {
        $this->db->where('cve_dependencia', $cve_dependencia);
        $result = $this->db->delete('dependencias');
    }

}
