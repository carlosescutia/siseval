<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('parametros_sistema_model');
        $this->load->model('proyectos_model');
    }

    public function index()
    {
        $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion_publico();

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/index', $data);
        $this->load->view('templates/pubfooter');
    }

}
