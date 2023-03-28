<?php
class Clasificaciones_supervisor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_clasificaciones_supervisor() {
        $sql = 'select * from clasificaciones_supervisor order by orden ;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_clasificacion_supervisor($id_clasificacion_supervisor) {
        $sql = 'select * from clasificaciones_supervisor where id_clasificacion_supervisor = ?';
        $query = $this->db->query($sql, array($id_clasificacion_supervisor));
        return $query->row_array();
    }

    public function guardar($data, $id_clasificacion_supervisor)
    {
        if ($id_clasificacion_supervisor) {
            $this->db->where('id_clasificacion_supervisor', $id_clasificacion_supervisor);
            $this->db->update('clasificaciones_supervisor', $data);
            $id = $id_clasificacion_supervisor;
        } else {
            $this->db->insert('clasificaciones_supervisor', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_clasificacion_supervisor)
    {
        $this->db->where('id_clasificacion_supervisor', $id_clasificacion_supervisor);
        $result = $this->db->delete('clasificaciones_supervisor');
    }

}
