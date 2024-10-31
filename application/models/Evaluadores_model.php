<?php
class Evaluadores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_evaluadores($salida=null) {
        $this->load->dbutil();

        $sql = 'select * from evaluadores ;';
        $query = $this->db->query($sql);

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function get_evaluadores_busqueda($buscar_evaluador) {
        if ($buscar_evaluador !== '') {
            $buscar_evaluador = '%' . $buscar_evaluador . '%';
        }
        $sql = 'select * from evaluadores where id_evaluador::text ilike ? or nom_evaluador ilike ? ';
        $query = $this->db->query($sql, array($buscar_evaluador, $buscar_evaluador));
        return $query->result_array();
    }

    public function get_evaluador($id_evaluador) {
        $sql = 'select * from evaluadores where id_evaluador = ?';
        $query = $this->db->query($sql, array($id_evaluador));
        return $query->row_array();
    }

    public function get_listado_evaluadores($salida=null) {
        $this->load->dbutil();

        $sql = ""
            ."select  "
            ."ver.id_evaluador, e.nom_evaluador, e.observaciones, "
            ."count(ver.id_evaluador) as num_evaluaciones,  "
            ."sum(ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad) as suma_puntos ,  "
            ."round(sum(ver.puntualidad + ver.solidez + ver.objetividad + ver.claridad + ver.disponibilidad)::numeric(10,2) / count(ver.id_evaluador)) as promedio "
            ."from  "
            ."valoraciones_evaluador ver  "
            ."left join evaluadores e on e.id_evaluador = ver.id_evaluador "
            ."group by  "
            ."ver.id_evaluador, e.nom_evaluador, e.observaciones "
            ."";
        $query = $this->db->query($sql);

        if ($salida == 'csv') {
            $delimiter = ",";
            $newline = "\r\n";
            return $this->dbutil->csv_from_result($query, $delimiter, $newline);
        } else {
            return $query->result_array();
        }
    }

    public function guardar($data, $id_evaluador)
    {
        if ($id_evaluador) {
            $this->db->where('id_evaluador', $id_evaluador);
            $this->db->update('evaluadores', $data);
            $id = $id_evaluador;
        } else {
            $this->db->insert('evaluadores', $data);
            $id = $data['id_evaluador'];
        }
        return $id;
    }

    public function eliminar($id_evaluador)
    {
        $this->db->where('id_evaluador', $id_evaluador);
        $result = $this->db->delete('evaluadores');
    }

}
