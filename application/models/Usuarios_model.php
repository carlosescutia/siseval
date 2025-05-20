<?php
class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_usuario_credenciales($usuario, $pwd) {
        $sql = ''
            .'select '
            .'u.*, '
            .'d.nom_dependencia, '
            .'r.nom_rol '
            .'from '
            .'usuarios u '
            .'left join roles r on u.cve_rol = r.cve_rol '
            .'left join dependencias d on u.cve_dependencia = d.cve_dependencia '
            .'where '
            .'u.usuario = ? '
            .'and u.password = ? '
            .'and u.activo = 1 '
            .'';
        $query = $this->db->query($sql, array($usuario, $pwd));
        return $query->row();
    }

    public function get_usuarios($periodo) {
        //$sql = 'select u.*, r.nom_rol, d.nom_dependencia, (select count(*) from accesos_sistema_usuario asu where asu.cve_usuario = u.cve_usuario) as num_permisos from usuarios u left join roles r on u.cve_rol = r.cve_rol left join dependencias d on u.cve_dependencia = d.cve_dependencia order by u.cve_usuario;';
        $sql = ""
            ."select "
            ."u.*, r.nom_rol, d.nom_dependencia, "
            ."(select count(*) from accesos_sistema_usuario asu where asu.cve_usuario = u.cve_usuario) as num_permisos "
            ."from "
            ."usuarios u "
            ."left join roles r on u.cve_rol = r.cve_rol "
            ."left join get_dependencia_periodo(u.cve_dependencia, ?) d on u.cve_dependencia = d.cve_dependencia "
            ."order by "
            ."u.cve_usuario "
            ."";
        $query = $this->db->query($sql, array($periodo));
        return $query->result_array();
    }

    public function get_usuario($cve_usuario) {
        $sql = 'select u.*, d.nom_dependencia, r.nom_rol from usuarios u left join roles r on u.cve_rol = r.cve_rol left join dependencias d on u.cve_dependencia = d.cve_dependencia where u.cve_usuario = ?;';
        $query = $this->db->query($sql, array($cve_usuario));
        return $query->row_array();
    }

    public function guardar($data, $cve_usuario)
    {
        if ($cve_usuario) {
            $this->db->where('cve_usuario', $cve_usuario);
            $this->db->update('usuarios', $data);
            $id = $cve_usuario;
        } else {
            $this->db->insert('usuarios', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_usuario)
    {
        $this->db->where('cve_usuario', $cve_usuario);
        $result = $this->db->delete('usuarios');
        return $result;
    }

}
