<?php
class Propuestas_evaluacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_propuesta_evaluacion($id_propuesta_evaluacion) {
        $sql = 'select pe.*, te.nom_tipo_evaluacion, d.nom_dependencia from propuestas_evaluacion pe left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion left join dependencias d on pe.cve_dependencia = d.cve_dependencia where id_propuesta_evaluacion = ?;';
        $query = $this->db->query($sql, array($id_propuesta_evaluacion));
        return $query->row_array();
    }

    public function get_num_propuestas_evaluacion_proyecto_dependencia($cve_proyecto, $cve_dependencia) {
        $sql = 'select count(*) as num from propuestas_evaluacion where cve_proyecto = ? and cve_dependencia = ? ;';
        $query = $this->db->query($sql, array($cve_proyecto, $cve_dependencia));
        return $query->row_array();
    }

    public function get_propuestas_evaluacion_proyecto($cve_proyecto) {
        $sql = ""
			."select "
			."pe.*, te.nom_tipo_evaluacion, d.nom_dependencia, "
			."(select count(*) from calificaciones_propuesta cap where cap.id_propuesta_evaluacion = pe.id_propuesta_evaluacion) as num_calificaciones "
			."from  "
			."propuestas_evaluacion pe  "
			."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion  "
			."left join dependencias d on pe.cve_dependencia = d.cve_dependencia  "
			."where  "
			."cve_proyecto = ?  "
			."order by  "
			."d.nom_dependencia, te.nom_tipo_evaluacion "
			."";
        $query = $this->db->query($sql, array($cve_proyecto));
        return $query->result_array();
    }

    public function get_ods_propuesta_evaluacion($id_propuesta_evaluacion) {
        $sql = ""
            ."select "
            ."distinct od.cve_objetivo_desarrollo, od.nom_objetivo_desarrollo "
            ."from "
            ."propuestas_evaluacion pe "
            ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
            ."left join programas_metas pm on pm.cve_programa = py.cve_programa "
            ."left join metas_ods mo on pm.cve_meta_ods = mo.cve_meta_ods "
            ."left join objetivos_desarrollo od on od.cve_objetivo_desarrollo = mo.cve_objetivo_desarrollo "
            ."where "
            ."pe.id_propuesta_evaluacion = ? "
			."";
        $query = $this->db->query($sql, array($id_propuesta_evaluacion));
        return $query->result_array();
    }

    public function get_tot_info_disponible_propuesta_evaluacion($id_propuesta_evaluacion) {
        $sql = ""
            ."select "
            ."id_propuesta_evaluacion, "
            ."( "
            ."coalesce(info_diagnostico, 0) "
            ."+ coalesce(info_mir, 0) "
            ."+ coalesce(info_reglasop, 0) "
            ."+ coalesce(info_regsadm, 0) "
            ."+ coalesce(info_fuentes_of, 0) "
            ."+ coalesce(info_progpresup, 0) "
            ."+ coalesce(info_padronben, 0) "
            ."+ coalesce(info_lineamientos, 0) "
            ."+ coalesce(info_guiasop, 0) "
            ."+ coalesce(info_normativa, 0) "
            ."+ coalesce(info_otro, 0) "
            .") as tot_info_disponible "
            ."from "
            ."propuestas_evaluacion "
            ."where "
            ."id_propuesta_evaluacion = ? ; "
			."";
        $query = $this->db->query($sql, array($id_propuesta_evaluacion));
        return $query->row_array()['tot_info_disponible'] ?? null ;
    }

    public function guardar($data, $id_propuesta_evaluacion)
    {
        if ($id_propuesta_evaluacion) {
            $this->db->where('id_propuesta_evaluacion', $id_propuesta_evaluacion);
            $this->db->update('propuestas_evaluacion', $data);
            $id = $id_propuesta_evaluacion;
        } else {
            $this->db->insert('propuestas_evaluacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_propuesta_evaluacion)
    {
        $this->db->where('id_propuesta_evaluacion', $id_propuesta_evaluacion);
        $result = $this->db->delete('propuestas_evaluacion');
    }

}
