<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');

        $this->load->model('proyectos_model');
        $this->load->model('dependencias_model');
    }

    public function index()
    {
        $data['proyectos'] = $this->proyectos_model->get_programas_publicacion();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/index', $data);
        $this->load->view('templates/pubfooter');
    }

    public function gestion()
    {
        $cve_dependencia_filtro = '%';
        $anexo_social = '0';
        $evaluaciones_propuestas = '0';

        $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;

        $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion($cve_dependencia_filtro);
        $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/index', $data);
        $this->load->view('templates/pubfooter');
    }

}
