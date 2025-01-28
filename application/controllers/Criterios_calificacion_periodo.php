<?php
class Criterios_calificacion_periodo extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('criterios_calificacion_periodo_model');
        $this->load->model('periodos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function guardar($id_criterio_calificacion_periodo=null)
    {
        if ($this->session->userdata('logueado')) {

            $criterio_calificacion_periodo = $this->input->post();
            if ($criterio_calificacion_periodo) {

                if ($id_criterio_calificacion_periodo) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_criterio' => $criterio_calificacion_periodo['nom_criterio'],
                    'periodo' => $criterio_calificacion_periodo['periodo'],
                );
                $id_criterio_calificacion_periodo = $this->criterios_calificacion_periodo_model->guardar($data, $id_criterio_calificacion_periodo);

                // registro en bitacora
                $entidad = 'criterios_calificacion_periodo';
                $valor = $criterio_calificacion_periodo['periodo'] . " " . $criterio_calificacion_periodo['nom_criterio'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'periodos/detalle/' . $criterio_calificacion_periodo['id_periodo']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_criterio_calificacion_periodo)
    {
        if ($this->session->userdata('logueado')) {

            $criterio_calificacion_periodo = $this->criterios_calificacion_periodo_model->get_criterio_calificacion_periodo($id_criterio_calificacion_periodo);
            $periodo = $this->periodos_model->get_periodo_nom_periodo($criterio_calificacion_periodo['periodo']);
            $id_periodo = $periodo['id_periodo'];
            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'criterios_calificacion_periodo';
            $valor = $criterio_calificacion_periodo['periodo'] . " " . $criterio_calificacion_periodo['nom_criterio'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->criterios_calificacion_periodo_model->eliminar($id_criterio_calificacion_periodo);

            redirect(base_url() . 'periodos/detalle/' . $id_periodo);

        } else {
            redirect('inicio/login');
        }
    }

}

