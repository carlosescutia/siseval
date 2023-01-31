<?php
class Opciones_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('opciones_sistema_model');
        $this->load->model('accesos_sistema_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/opciones_sistema/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            
            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $data['opcion_sistema'] = $this->opciones_sistema_model->get_opcion($cve_opcion);

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/opciones_sistema/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/opciones_sistema/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_opcion=null)
    {
        if ($this->session->userdata('logueado')) {

            $opciones_sistema = $this->input->post();
            if ($opciones_sistema) {
                $data = array(
                    'cod_opcion' => $opciones_sistema['cod_opcion'],
                    'nom_opcion' => $opciones_sistema['nom_opcion'],
                    'url' => $opciones_sistema['url'],
                    'es_menu' => $opciones_sistema['es_menu']
                );
                $this->opciones_sistema_model->guardar($data, $cve_opcion);
            }
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {

            $this->opciones_sistema_model->eliminar($cve_opcion);
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

}
