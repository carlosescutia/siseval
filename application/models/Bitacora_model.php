<?php
class Bitacora_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardar($data)
    {
        $result = $this->db->insert('bitacora', $data);
        return $result;
    }

    public function get_bitacora($dependencia, $area, $cve_rol, $accion, $entidad)
    {
        if ($cve_rol == 'sup') {
            $area = '%';
        }
        if ($cve_rol == 'adm') {
            $dependencia = '%';
            $area = '%';
        }
        $sql = "select b.* from bitacora b where b.dependencia LIKE ? and b.area LIKE ?";
        $parametros = array();
        array_push($parametros, "$dependencia");
        array_push($parametros, "$area");
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
