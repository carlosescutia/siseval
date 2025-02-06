<?php
class Metas_ods_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_metas_ods() {
        $sql = 'select * from metas_ods order by cve_meta_ods;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_metas_proyecto($id_proyecto) {
        $sql = ''
            .'select  '
            .'py.cve_proyecto, py.cve_programa, mo.cve_meta_ods, mo.nom_meta_ods, od.cve_objetivo_desarrollo, od.nom_objetivo_desarrollo '
            .'from  '
            .'proyectos py '
            .'left join programas_metas pm on py.cve_programa = pm.cve_programa '
            .'left join metas_ods mo on pm.cve_meta_ods = mo.cve_meta_ods  '
            .'left join objetivos_desarrollo od on mo.cve_objetivo_desarrollo = od.cve_objetivo_desarrollo '
            .'where  '
            .'py.id_proyecto = ? '
            .'order by '
            .'od.cve_objetivo_desarrollo, mo.cve_meta_ods '
            .'';
        $query = $this->db->query($sql, array($id_proyecto));
        return $query->result_array();
    }

    public function get_meta_ods($id_meta_ods) {
        $sql = 'select * from metas_ods where id_meta_ods = ?;';
        $query = $this->db->query($sql, array($id_meta_ods));
        return $query->row_array();
    }

    public function guardar($data, $id_meta_ods)
    {
        if ($id_meta_ods) {
            $this->db->where('id_meta_ods', $id_meta_ods);
            $this->db->update('metas_ods', $data);
            $id = $id_meta_ods;
        } else {
            $this->db->insert('metas_ods', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function eliminar($id_meta_ods)
    {
        $this->db->where('id_meta_ods', $id_meta_ods);
        $result = $this->db->delete('metas_ods');
    }

}
