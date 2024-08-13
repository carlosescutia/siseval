<?php
class Accesos_sistema_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_accesos_sistema() {
        $sql = 'select acs.*, o.nom_opcion, r.nom_rol from accesos_sistema acs left join opciones_sistema o on acs.cod_opcion = o.cod_opcion left join roles r on acs.cve_rol = r.cve_rol order by cve_rol, cod_opcion;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_acceso_sistema($cve_acceso) {
        $sql = 'select * from accesos_sistema where cve_acceso = ?;';
        $query = $this->db->query($sql, array($cve_acceso));
        return $query->row_array();
    }

    public function get_accesos_sistema_rol_usuario($cve_usuario) {
        // solo accesos del rol al que pertenece el usuario
        $sql = "select acs.cod_opcion, ops.nom_opcion from accesos_sistema acs left join opciones_sistema ops on acs.cod_opcion = ops.cod_opcion left join usuarios usu on acs.cve_rol = usu.cve_rol where usu.cve_usuario = ?";
        $query = $this->db->query($sql, array($cve_usuario));
        return $query->result_array();
    }

    public function get_permisos_usuario($cve_usuario) {
        // accesos del usuario y su rol
        $sql = ""
        ."select "
        ."  string_agg(cod_opcion::text, ',') as permisos "
        ."from ( "
        ."  select "
        ."    acs.cod_opcion "
        ."  from "
        ."    accesos_sistema acs "
        ."    left join usuarios usu on acs.cve_rol = usu.cve_rol "
        ."  where "
        ."    usu.cve_usuario = ? "
        ."  union "
        ."  select "
        ."    asu.cod_opcion "
        ."  from "
        ."    accesos_sistema_usuario asu "
        ."  where "
        ."    asu.cve_usuario = ? "
        .") subconsulta "
        ."";

        $query = $this->db->query($sql, array($cve_usuario, $cve_usuario));
        return $query->row_array()['permisos'] ?? null ;
    }

    public function get_acceso_opcion_rol($cod_opcion, $cve_rol) {
        $sql = 'select * from accesos_sistema where cod_opcion = ? and $cve_rol = ?;';
        $query = $this->db->query($sql, array($cod_opcion, $cve_rol));
        return $query->row_array();
    }

    public function get_roles_acceso($cve_opcion) {
        // Devuelve roles con acceso a una opción
        $sql = 'select acs.cve_rol, r.nom_rol from accesos_sistema acs left join opciones_sistema ops on ops.cod_opcion = acs.cod_opcion left join roles r on r.cve_rol = acs.cve_rol where ops.cve_opcion = ?';
        $query = $this->db->query($sql, array($cve_opcion));
        return $query->result_array();
    }


    public function guardar($data, $cve_acceso)
    {
        if ($cve_acceso) {
            $this->db->where('cve_acceso', $cve_acceso);
            $this->db->update('accesos_sistema', $data);
            $id = $cve_acceso;
        } else {
            $this->db->insert('accesos_sistema', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($cve_acceso)
    {
        $this->db->where('cve_acceso', $cve_acceso);
        $result = $this->db->delete('accesos_sistema');
        return $result;
    }

}
