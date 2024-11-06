<?php
class Valoraciones_evaluacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_valoraciones_evaluacion() {
        $sql = 'select * from valoraciones_evaluacion order by id_valoracion_evaluacion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_valoracion_evaluacion($id_valoracion_evaluacion) {
        $sql = ""
            ."select  "
            ."ven.*, e.id_evaluador, e.nom_evaluador, pe.cve_proyecto, te.nom_tipo_evaluacion, py.nom_proyecto, pg.nom_programa, "
            ."(ven.informe + ven.antecedentes + ven.metodologia + ven.informacion + ven.analisis + ven.conclusiones "
            ."+ ven.acuerdos_institucionales + ven.acuerdos_confidencialidad + ven.derechos + ven.orientacion + ven.autonomia + ven.genero ) as puntaje_valoracion_evaluacion "
            ."from valoraciones_evaluacion ven  "
            ."left join valoraciones_evaluador ver on ver.id_propuesta_evaluacion = ven.id_propuesta_evaluacion "
            ."left join evaluadores e on e.id_evaluador = ver.id_evaluador "
            ."left join propuestas_evaluacion pe on pe.id_propuesta_evaluacion = ven.id_propuesta_evaluacion  "
            ."left join tipos_evaluacion te on te.id_tipo_evaluacion = pe.id_tipo_evaluacion "
            ."left join proyectos py on py.cve_proyecto = pe.cve_proyecto  "
            ."left join programas pg on pg.cve_programa = py.cve_programa "
            ."where ven.id_valoracion_evaluacion = ? "
            ."";
        $query = $this->db->query($sql, array($id_valoracion_evaluacion));
        return $query->row_array();
    }

    public function guardar($data, $id_valoracion_evaluacion)
    {
        if ($id_valoracion_evaluacion) {
            $this->db->where('id_valoracion_evaluacion', $id_valoracion_evaluacion);
            $result = $this->db->update('valoraciones_evaluacion', $data);
            $id = $id_valoracion_evaluacion;
        } else {
            $result = $this->db->insert('valoraciones_evaluacion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_valoracion_evaluacion)
    {
        $this->db->where('id_valoracion_evaluacion', $id_valoracion_evaluacion);
        $result = $this->db->delete('valoraciones_evaluacion');
        return $result;
    }

}
