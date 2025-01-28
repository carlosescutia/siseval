<?php
class Nocarga_evaluaciones extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('nocarga_evaluaciones_model');

        $this->etapa_modulo = 1;
        $this->nom_etapa_modulo = 'planificacion.etapa_activa';
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $nocarga_evaluacion = $this->input->post();
            if ($nocarga_evaluacion) {

                $accion = 'agregó';

                // guardado
                $data = array(
                    'cve_dependencia' => $nocarga_evaluacion['cve_dependencia'],
                    'periodo' => $nocarga_evaluacion['periodo'],
                );
                $this->nocarga_evaluaciones_model->guardar($data);

                // registro en bitacora
                $entidad = 'nocarga_evaluaciones';
                $valor = $nocarga_evaluacion['cve_dependencia'] . " " . $nocarga_evaluacion['periodo'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'proyectos');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar()
    {
        if ($this->session->userdata('logueado')) {

            $nocarga_evaluacion = $this->input->post();
            if ($nocarga_evaluacion) {

                $accion = 'eliminó';

                // eliminado
                $data = array(
                    'cve_dependencia' => $nocarga_evaluacion['cve_dependencia'],
                    'periodo' => $nocarga_evaluacion['periodo'],
                );
                $this->nocarga_evaluaciones_model->eliminar($data);

                // registro en bitacora
                $entidad = 'nocarga_evaluaciones';
                $valor = $nocarga_evaluacion['cve_dependencia'] . " " . $nocarga_evaluacion['periodo'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'proyectos');

        } else {
            redirect('inicio/login');
        }
    }


}
