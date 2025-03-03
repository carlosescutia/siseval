<?php
class Inicio extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('usuarios_model');
        $this->load->model('eventos_model');
        $this->load->model('proyectos_model');
        $this->load->model('parametros_sistema_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('dependencias_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            // en la funcion recargar_permisos, periodo = anio_sesion para valor default
            // en funciones index, recargar periodos desde la bd
            $periodos = $this->proyectos_model->get_anios_proyectos();
            $this->session->set_userdata('periodos', $periodos);
            $data['userdata'] = $this->session->userdata;

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['eventos'] = $this->eventos_model->get_eventos($anio_sesion);

            $this->load->view('templates/header', $data);
            $this->load->view('inicio/inicio', $data);
            $this->load->view('templates/footer');
        } else {
            redirect(base_url() . 'inicio/login');
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

        // registro en bitacora
        $accion = 'logout';
        $entidad = '';
        $valor = '';
        $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

        $this->session->set_userdata($usuario_data);
        redirect(base_url() . 'inicio/login');
    }

    public function post_login() {
        if ($this->input->post()) {
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $usuario = $this->usuarios_model->get_usuario_credenciales($usuario, $password);
            if ($usuario) {
                $permisos_usuario = explode(',', $this->accesos_sistema_model->get_permisos_usuario($usuario->cve_usuario));
                $opciones_sistema = $this->opciones_sistema_model->get_opciones_sistema();
                $etapa_siseval = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');
                $anio_activo = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_activo');
                $anio_sesion = $anio_activo;
                $periodos = $this->proyectos_model->get_anios_proyectos();
                $dependencia_periodo = $this->dependencias_model->get_dependencia_periodo($usuario->cve_dependencia, $anio_sesion);
                $usuario_data = array(
                    'cve_usuario' => $usuario->cve_usuario,
                    'cve_dependencia' => $usuario->cve_dependencia,
                    'nom_dependencia' => $dependencia_periodo['nom_dependencia'],
                    'cve_rol' => $usuario->cve_rol,
                    'nom_usuario' => $usuario->nom_usuario,
                    'usuario' => $usuario->usuario,
                    'permisos_usuario' => $permisos_usuario,
                    'opciones_sistema' => $opciones_sistema,
                    'etapa_siseval' => $etapa_siseval,
                    'anio_activo' => $anio_activo,
                    'anio_sesion' => $anio_sesion,
                    'periodos' => $periodos,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);

                // registro en bitacora
                $accion = 'login';
                $entidad = '';
                $valor = '';
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);
                redirect(base_url() . 'inicio');
            } else {
                $this->session->set_flashdata('error', 'Usuario o contraseña incorrectos');
                redirect(base_url() . 'inicio/login');
            }
        } else {
            redirect(base_url() . 'inicio/login');
        }
    }

    public function update_anio_sesion() {
        if ($this->input->post()){
            $anio_sesion = $this->input->post('anio_sesion');
            $previous_url = $this->input->post('previous_url');
            $this->session->set_userdata('anio_sesion', $anio_sesion);
            redirect($previous_url);
        }
    }
}
