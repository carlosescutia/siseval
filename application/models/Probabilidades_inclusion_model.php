<?php
class Probabilidades_inclusion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_probabilidades_inclusion() {
        $sql = 'select * from probabilidades_inclusion order by periodo desc, orden';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_probabilidad_inclusion($id_probabilidad_inclusion) {
        $sql = 'select * from probabilidades_inclusion where id_probabilidad_inclusion = ?';
        $query = $this->db->query($sql, array($id_probabilidad_inclusion));
        return $query->row_array();
    }

    public function guardar($data, $id_probabilidad_inclusion)
    {
        if ($id_probabilidad_inclusion) {
            $this->db->where('id_probabilidad_inclusion', $id_probabilidad_inclusion);
            $this->db->update('probabilidades_inclusion', $data);
            $id = $id_probabilidad_inclusion;
        } else {
            $this->db->insert('probabilidades_inclusion', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_probabilidad_inclusion)
    {
        $this->db->where('id_probabilidad_inclusion', $id_probabilidad_inclusion);
        $result = $this->db->delete('probabilidades_inclusion');
    }

}
