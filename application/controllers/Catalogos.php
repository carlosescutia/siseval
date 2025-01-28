<?php
class Catalogos extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        $this->load->model('proyectos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $periodos = $this->proyectos_model->get_anios_proyectos();
            $this->session->set_userdata('periodos', $periodos);
            $data['userdata'] = $this->session->userdata;

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

}
