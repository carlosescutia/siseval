<?php
class Accesos_sistema_usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_accesos_sistema_usuario_todos() {
        $sql = 'select * from accesos_sistema_usuario order by cod_opcion';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_acceso_sistema_usuario($cve_acceso) {
        $sql = 'select * from accesos_sistema_usuario where cve_acceso = ?';
        $query = $this->db->query($sql, array($cve_acceso));
        return $query->row_array();
    }


    public function get_accesos_sistema_usuario($cve_usuario) {
        // solo accesos del usuario
        $sql = "select asu.cve_usuario, asu.cve_acceso, asu.cod_opcion, ops.nom_opcion from accesos_sistema_usuario asu left join opciones_sistema ops on asu.cod_opcion = ops.cod_opcion where cve_usuario = ?";
        $query = $this->db->query($sql, array($cve_usuario));
        return $query->result_array();
    }

    public function get_usuarios_acceso($cve_opcion) {
        // Devuelve usuarios con acceso a una opción
        $sql = 'select asu.cve_usuario, u.nom_usuario, d.nom_dependencia from accesos_sistema_usuario asu left join opciones_sistema ops on ops.cod_opcion = asu.cod_opcion left join usuarios u on u.cve_usuario = asu.cve_usuario left join dependencias d on d.cve_dependencia = u.cve_dependencia where ops.cve_opcion = ? ;';
        $query = $this->db->query($sql, array($cve_opcion));
        return $query->result_array();
    }


    public function guardar($data, $cve_acceso)
    {
        if ($cve_acceso) {
            $this->db->where('cve_acceso', $cve_acceso);
            $this->db->update('accesos_sistema_usuario', $data);
            $id = $cve_acceso;
        } else {
            $this->db->insert('accesos_sistema_usuario', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_acceso)
    {
        $this->db->where('cve_acceso', $cve_acceso);
        $result = $this->db->delete('accesos_sistema_usuario');
        return $result;
    }

}

