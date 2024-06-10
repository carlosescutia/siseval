<?php
class Bitacora_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardar($data)
    {
        $this->db->insert('bitacora', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function get_bitacora($nom_dependencia, $cve_rol, $accion, $entidad)
    {
        if ($cve_rol == 'adm') {
            $nom_dependencia = '%';
        }
        $sql = "select b.* from bitacora b where b.nom_dependencia LIKE ? ";
        $parametros = array();
        array_push($parametros, "$nom_dependencia");
        if ($accion <> "") {
            $sql .= ' and b.accion = ?';
            array_push($parametros, "$accion");
        } 
        if ($entidad <> "") {
            $sql .= ' and b.entidad = ?';
            array_push($parametros, "$entidad");
        } 
        $sql .= ' order by b.cve_evento desc;';
        $query = $this->db->query($sql, $parametros);
        return $query->result_array();
    }

}
