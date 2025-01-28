<?php
class Publico extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('directory');

        $this->load->model('parametros_sistema_model');
        $this->load->model('proyectos_model');
    }

    public function index()
    {
        // pagination
        $config = array();
        $config['base_url'] = base_url() . 'publico' ;
        $config['total_rows'] = $this->proyectos_model->num_programas_agenda_evaluacion_publico();
        $config['per_page'] = $this->parametros_sistema_model->get_parametro_sistema_nom('num_registros_tabla_publico');
        $config['uri_segment'] = 2;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Inicio';
        $config['last_link'] = 'Fin';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['links'] = $this->pagination->create_links();

        $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion_publico($config['per_page'], $page);

        $this->load->view('templates/pubheader', $data);
        $this->load->view('publico/index', $data);
        $this->load->view('templates/pubfooter');
    }

}
