<?php
class Tipos_evaluacion_periodo extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('tipos_evaluacion_periodo_model');
        $this->load->model('periodos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $tipo_evaluacion_periodo = $this->input->post();
            if ($tipo_evaluacion_periodo) {
                $id_periodo = $tipo_evaluacion_periodo['id_periodo'];

                // guardado
                $data = array(
                    'id_tipo_evaluacion' => $tipo_evaluacion_periodo['id_tipo_evaluacion'],
                    'periodo' => $tipo_evaluacion_periodo['periodo'],
                );
                $id_tipo_evaluacion_periodo = $this->tipos_evaluacion_periodo_model->guardar($data);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'tipos_evaluacion_periodo';
                $valor = $tipo_evaluacion_periodo['periodo'] . " " . $tipo_evaluacion_periodo['id_tipo_evaluacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'periodos/detalle/' . $id_periodo);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_tipo_evaluacion_periodo)
    {
        if ($this->session->userdata('logueado')) {

            $tipo_evaluacion_periodo = $this->tipos_evaluacion_periodo_model->get_tipo_evaluacion_periodo($id_tipo_evaluacion_periodo);
            $periodo = $this->periodos_model->get_periodo_nom_periodo($tipo_evaluacion_periodo['periodo']);
            $id_periodo = $periodo['id_periodo'];
            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'tipos_evaluacion_periodo';
            $valor = $tipo_evaluacion_periodo['periodo'] . " " . $tipo_evaluacion_periodo['nom_criterio'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->tipos_evaluacion_periodo_model->eliminar($id_tipo_evaluacion_periodo);

            redirect(base_url() . 'periodos/detalle/' . $id_periodo);

        } else {
            redirect('inicio/login');
        }
    }

}


