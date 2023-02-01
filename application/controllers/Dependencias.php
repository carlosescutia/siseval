<?php
class Dependencias extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('dependencias_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
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

            $data['dependencias'] = $this->dependencias_model->get_dependencias();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/dependencias/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_dependencia)
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

            $data['dependencias'] = $this->dependencias_model->get_dependencia($cve_dependencia);

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/dependencias/detalle', $data);
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
            $this->load->view('catalogos/dependencias/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_dependencia=null)
    {
        if ($this->session->userdata('logueado')) {

            $nueva_dependencia = is_null($cve_dependencia);

            $dependencias = $this->input->post();
            if ($dependencias) {
                $data = array(
                    'nom_dependencia' => $dependencias['nom_dependencia']
                );
                $cve_dependencia = $this->dependencias_model->guardar($data, $cve_dependencia);
            }

            redirect('dependencias');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_dependencia)
    {
        if ($this->session->userdata('logueado')) {

            $this->dependencias_model->eliminar($cve_dependencia);
            redirect('dependencias');

        } else {
            redirect('inicio/login');
        }
    }

}
