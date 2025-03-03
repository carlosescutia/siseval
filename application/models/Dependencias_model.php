<?php
class Dependencias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->dbutil();
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

    public function get_dependencia_periodo($cve_dependencia, $periodo) {
        $sql = 'select dp.*, (case when nce.cve_dependencia > 0 then 0 else 1 end) as carga_evaluaciones from get_dependencia_periodo(?,?) dp left join nocarga_evaluaciones nce on nce.cve_dependencia = dp.cve_dependencia and nce.periodo = ? ';
        $query = $this->db->query($sql, array($cve_dependencia, $periodo, $periodo));
        return $query->row_array();
    }

    public function get_dependencias_proyectos($cve_dependencia, $anexo_social, $evaluaciones_propuestas, $periodo) {
        $sql = ""
            ."select  "
            ."py.cve_dependencia, d.nom_dependencia, (case when nce.cve_dependencia > 0 then 0 else 1 end) as carga_evaluaciones "
            ."from  "
            ."proyectos py  "
            ."left join get_dependencia_periodo(py.cve_dependencia, ?) d on py.cve_dependencia = d.cve_dependencia  "
            ."left join nocarga_evaluaciones nce on nce.cve_dependencia = py.cve_dependencia and nce.periodo = ? "
            ."where  "
            ."py.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."";
        $parametros = array();
        array_push($parametros, "$periodo");
        array_push($parametros, "$periodo");
        array_push($parametros, "$cve_dependencia");
        array_push($parametros, "$periodo");
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
        $sql .= ' group by py.cve_dependencia, d.nom_dependencia, nce.cve_dependencia  ';
        $sql .= ' order by py.cve_dependencia;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_dependencias_evaluaciones($cve_dependencia, $sesion) {
        $sql = ""
            ."select  "
            ."dpe.cve_dependencia, dpe.nom_dependencia  "
            ."from  "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on py.id_proyecto = pe.id_proyecto "
            ."left join dependencias dpe on py.cve_dependencia = dpe.cve_dependencia "
            ."where  "
            ."dpe.cve_dependencia::text LIKE ? "
            ."and py.periodo = ? "
            ."";
        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        array_push($parametros, "$sesion");
        $sql .= ' group by dpe.cve_dependencia, dpe.nom_dependencia ';
        $sql .= ' order by dpe.cve_dependencia;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

    public function get_status_dependencias($evaluaciones, $propuestas, $periodo, $salida) {
        $sql = ""
            ."select  "
            ."d.cve_dependencia, dp.nom_dependencia, dp.nom_completo_dependencia, "
            ."(case when nce.cve_dependencia > 0 then 'no' else 'si' end) as solicita_evaluaciones, "
            ."(select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.id_proyecto = py.id_proyecto where py.periodo = ? and py.cve_dependencia = d.cve_dependencia) as num_propuestas "
            ."from  "
            ."dependencias d "
            ."left join get_dependencia_periodo(d.cve_dependencia, ?) dp on dp.cve_dependencia = d.cve_dependencia "
            ."left join nocarga_evaluaciones nce on nce.cve_dependencia = d.cve_dependencia and nce.periodo = ? "
            ."where "
            ."true "
            ."";
        $parametros = array();
        array_push($parametros, "$periodo");
        array_push($parametros, "$periodo");
        array_push($parametros, "$periodo");
        if ($evaluaciones <> "") {
            $sql .= "and d.carga_evaluaciones = ? ";
            array_push($parametros, "$evaluaciones");
        } 
        if ($propuestas == '0') {
            $sql .= "and (select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.id_proyecto = py.id_proyecto where py.cve_dependencia = d.cve_dependencia) = 0";
        } 
        if ($propuestas > '0') {
            $sql .= "and (select count(pe.id_propuesta_evaluacion) from propuestas_evaluacion pe left join proyectos py on pe.id_proyecto = py.id_proyecto where py.cve_dependencia = d.cve_dependencia) > 0";
        } 
        $sql .= ' order by d.nom_dependencia;';
        $query = $this->db->query($sql, $parametros);

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
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
