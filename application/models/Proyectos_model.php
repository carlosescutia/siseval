<?php
class Proyectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_proyectos_dependencia($cve_dependencia, $anexo_social, $evaluaciones_propuestas) {
        $sql = ''
			.'select '
            .'py.*, pg.*,  '
			.'(select count(*) from propuestas_evaluacion where cve_proyecto = py.cve_proyecto) as status_actual, '
			.'(select count(distinct(cp.id_propuesta_evaluacion)) from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp. id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.cve_proyecto = py.cve_proyecto) as propuestas_calificadas, '
			.'(select count(*) from evaluaciones ev left join proyectos pry on ev.cve_proyecto = pry.cve_anterior_proyecto where pry.cve_proyecto = py.cve_proyecto) as status_previo, '
			.'(select count(*) as num_calif_dependencias from calificaciones_propuesta cp left join propuestas_evaluacion pe on cp.id_propuesta_evaluacion = pe.id_propuesta_evaluacion where pe.cve_proyecto = py.cve_proyecto) as num_calif_dependencias '
			.'from '
			.'proyectos py '
			.'left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia '
			.'where '
			.'pg.cve_dependencia::text LIKE ? '
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

    public function get_proyecto_id($id_proyecto) {
        $sql = 'select * from proyectos where id_proyecto = ?';
        $query = $this->db->query($sql, array($id_proyecto));
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

    public function get_programas_agenda_evaluacion($cve_dependencia) {
        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, pcp.puntaje, pcp.probabilidad "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."where "
            ."py.cve_dependencia::text LIKE '%' "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
			."";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_programas_agenda_evaluacion_archivos($limite=null, $inicio=null) {
        // lista de proyectos con archivos
        $dire = './doc/' ;
        $archivos = directory_map($dire);
        $lista = array();
        foreach ($archivos as $archivo) {
            $tipoarch = substr($archivo, 1, 2);
            if (in_array($tipoarch, array('if', 'tr'))) {
                $nom_arch = substr($archivo, 0, -4);
                $cve_proyecto = substr($nom_arch, 4);
                array_push($lista, $cve_proyecto);
            }
        }
        $lista_final = array_unique($lista);

        $sql = ""
            ."select "
            ."py.cve_dependencia, d.nom_dependencia, pg.cve_programa, pg.nom_programa, py.periodo, pe.cve_proyecto,  "
            ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, "
            ."te.orden as cve_tipo_evaluacion, te.nom_tipo_evaluacion, te.abrev_tipo_evaluacion, cs.cve_clasificacion_supervisor, cs.nom_clasificacion_supervisor, pcp.puntaje, pcp.probabilidad "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
            ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
            ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
            ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
            ."where "
            ."lower(pe.cve_proyecto) || te.abrev_tipo_evaluacion in ? "
            ."order by "
            ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
            ."limit " . $limite . " offset " . $inicio
			."";

        $query = $this->db->query($sql, array($lista_final));
        return $query->result_array();
    }

    public function num_programas_agenda_evaluacion_archivos($limite=null, $inicio=null) {
        // lista de proyectos con archivos
        $dire = './doc/' ;
        $archivos = directory_map($dire);
        $lista = array();
        foreach ($archivos as $archivo) {
            $tipoarch = substr($archivo, 1, 2);
            if (in_array($tipoarch, array('if', 'tr'))) {
                $nom_arch = substr($archivo, 0, -4);
                $cve_proyecto = substr($nom_arch, 4);
                array_push($lista, $cve_proyecto);
            }
        }
        $lista_final = array_unique($lista);

        $sql = ""
            ."select "
            ."count (*) as num_programas "
            ."from "
            ."propuestas_evaluacion pe  "
            ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
            ."where "
            ."lower(pe.cve_proyecto) || te.abrev_tipo_evaluacion in ? "
			."";

        $query = $this->db->query($sql, array($lista_final));
        return $query->row_array()['num_programas'];
    }


    public function get_propuestas_evaluacion($cve_dependencia) {
        $sql = ''
			.'select  '
			.'d.nom_dependencia, pg.cve_programa, pg.nom_programa, pe.cve_proyecto,  '
			.'py.nom_proyecto, te.nom_tipo_evaluacion '
			.'from  '
			.'propuestas_evaluacion pe  '
			.'left join proyectos py on pe.cve_proyecto = py.cve_proyecto  '
			.'left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia '
			.'left join dependencias d on py.cve_dependencia = d.cve_dependencia '
			.'left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion '
			.'where  '
			.'py.cve_dependencia::text LIKE ? '
			.'order by '
			.'d.nom_dependencia, pg.cve_programa, pe.cve_proyecto  '
            .'';
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->result_array();
    }

    public function get_estadisticas_proyectos_dependencia($cve_dependencia) {
        $sql = 'select sum(num_proyectos) as num_proyectos, sum(num_proyectos_propuesta) as num_proyectos_propuesta, sum(num_propuestas_calificadas) as num_propuestas_calificadas from estadisticas_dependencia where cve_dependencia::text LIKE ?';
        $parametros = array();
        array_push($parametros, "$cve_dependencia");
        $query = $this->db->query($sql, $parametros);
        return $query->row_array();
    }

    public function get_consecutivo_dependencia($cve_dependencia)
    {
        $sql = "select max(right(py.cve_proyecto, 2)) as consecutivo from proyectos py left join programas pg on py.cve_programa = pg.cve_programa where left(pg.cve_programa, 3) = 'PRO' and pg.cve_dependencia = ?";
        $query = $this->db->query($sql, array($cve_dependencia));
        return $query->row_array();
    }

    public function guardar($data, $id_proyecto)
    {
        if ($id_proyecto) {
            $this->db->where('id_proyecto', $id_proyecto);
            $this->db->update('proyectos', $data);
            $id = $id_proyecto;
        } else {
            $this->db->insert('proyectos', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_proyecto)
    {
        $this->db->where('id_proyecto', $id_proyecto);
        $result = $this->db->delete('proyectos');
    }

}
