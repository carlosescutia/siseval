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

    public function get_propuestas_evaluacion_proyecto($cve_proyecto) {
        $sql = 'select pe.*, te.nom_tipo_evaluacion, d.nom_dependencia from propuestas_evaluacion pe left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion left join dependencias d on pe.cve_dependencia = d.cve_dependencia where cve_proyecto = ?;';
        $query = $this->db->query($sql, array($cve_proyecto));
        return $query->result_array();
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
