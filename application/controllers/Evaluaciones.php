<?php
class Evaluaciones extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('evaluaciones_model');
        $this->load->model('proyectos_model');

        $this->etapa_modulo = 1;
        $this->nom_etapa_modulo = 'planificacion.etapa_activa';
    }

    public function detalle($id_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];
            $anio_sesion = $data['userdata']['anio_sesion'];

            $data['evaluacion'] = $this->evaluaciones_model->get_evaluacion($id_evaluacion, $cve_dependencia, $cve_rol);
            $cve_anterior_proyecto = $data['evaluacion']['cve_proyecto'];
            $data['proyecto'] = $this->proyectos_model->get_proyecto_anterior($cve_anterior_proyecto, $cve_dependencia, $cve_rol, $anio_sesion);

            $this->load->view('templates/header', $data);
            $this->load->view('evaluaciones/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

}
