<?php
class Accesos_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('roles_model');
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

            $data['accesos_sistema'] = $this->accesos_sistema_model->get_accesos_sistema();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/accesos_sistema/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/iniciar_sesion');
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

            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            $data['roles'] = $this->roles_model->get_roles();

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/accesos_sistema/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

    public function guardar($cve_acceso=null)
    {
        if ($this->session->userdata('logueado')) {

            $accesos_sistema = $this->input->post();
            if ($accesos_sistema) {
                $data = array(
                    'cod_opcion' => $accesos_sistema['cod_opcion'],
                    'cve_rol' => $accesos_sistema['cve_rol']
                );
                $this->accesos_sistema_model->guardar($data, $cve_acceso);
            }
            redirect('accesos_sistema');

        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

    public function eliminar($cve_acceso)
    {
        if ($this->session->userdata('logueado')) {

            $this->accesos_sistema_model->eliminar($cve_acceso);
            redirect('accesos_sistema');

        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

}
