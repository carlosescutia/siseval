<?php
class Inicio extends CI_Controller {

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
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $cve_dependencia = $this->session->userdata('cve_dependencia');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $cve_dependencia;
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            $data['etapa_siseval'] = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');

            $data['anio_propuestas'] = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_propuestas');
            $data['fecha_ini_evaluaciones'] = $this->parametros_sistema_model->get_parametro_sistema_nom('fecha_ini_evaluaciones');
            $data['fecha_fin_evaluaciones'] = $this->parametros_sistema_model->get_parametro_sistema_nom('fecha_fin_evaluaciones');
            $data['fecha_ini_observaciones'] = $this->parametros_sistema_model->get_parametro_sistema_nom('fecha_ini_observaciones');
            $data['fecha_fin_observaciones'] = $this->parametros_sistema_model->get_parametro_sistema_nom('fecha_fin_observaciones');

            $this->load->view('templates/header', $data);
            $this->load->view('inicio/inicio', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function login() {
        $this->session->sess_destroy();
        $data = array();
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('inicio/login', $data);
    }

    public function cerrar_sesion() {
        $usuario_data = array(
            'logueado' => FALSE
        );
        $usuario = $this->session->userdata('usuario');
        $nom_usuario = $this->session->userdata('nom_usuario');
        $cve_dependencia = $this->session->userdata('cve_dependencia');
        $nom_dependencia = $this->session->userdata('nom_dependencia');
        $data = array(
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i"),
            'origen' => $_SERVER['REMOTE_ADDR'],
            'usuario' => $usuario,
            'nom_usuario' => $nom_usuario,
            'nom_dependencia' => $nom_dependencia,
            'accion' => 'logout',
            'entidad' => '',
            'valor' => ''
        );
        $this->bitacora_model->guardar($data);
        $this->session->set_userdata($usuario_data);
        redirect('inicio/login');
    }

    public function post_login() {
        if ($this->input->post()) {
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $usuario_db = $this->usuarios_model->usuario_por_nombre($usuario, $password);
            if ($usuario_db) {
                $usuario_data = array(
                    'cve_usuario' => $usuario_db->cve_usuario,
                    'cve_dependencia' => $usuario_db->cve_dependencia,
                    'nom_dependencia' => $usuario_db->nom_dependencia,
                    'cve_rol' => $usuario_db->cve_rol,
                    'nom_usuario' => $usuario_db->nom_usuario,
                    'usuario' => $usuario_db->usuario,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);
                $data = array(
                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i"),
                    'origen' => $_SERVER['REMOTE_ADDR'],
                    'usuario' => $usuario_db->usuario,
                    'nom_usuario' => $usuario_db->nom_usuario,
                    'nom_dependencia' => $usuario_db->nom_dependencia,
                    'accion' => 'login',
                    'entidad' => '',
                    'valor' => ''
                );
                $this->bitacora_model->guardar($data);
                redirect('inicio');
            } else {
                $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                redirect('inicio/login');
            }
        } else {
            redirect('inicio/login');
        }
    }
}

