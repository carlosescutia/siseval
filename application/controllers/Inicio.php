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
        $this->load->model('tipos_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('recomendaciones_model');

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
            $anio_sesion = $data['userdata']['anio_sesion'];
            $cve_rol = $data['userdata']['cve_rol'];

            $cve_dependencia = $data['userdata']['cve_dependencia'];
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $filtros = $this->input->post();
            if ($filtros) {
                $periodo_filtro = $filtros['periodo_filtro'];
                $cve_dependencia_filtro = $filtros['cve_dependencia_filtro'];
                $tipo_evaluacion_filtro = $filtros['tipo_evaluacion_filtro'];
                $proyecto_evaluado_filtro = $filtros['proyecto_evaluado_filtro'];
                $filtros_proyectos = array(
                    'periodo_filtro' => $periodo_filtro,
                    'cve_dependencia_filtro' => $cve_dependencia_filtro,
                    'tipo_evaluacion_filtro' => $tipo_evaluacion_filtro,
                    'proyecto_evaluado_filtro' => $proyecto_evaluado_filtro,
                );
                $this->session->set_userdata($filtros_proyectos);
            } else {
                if ($this->session->userdata('periodo_filtro')) {
                    $periodo_filtro = $this->session->userdata('periodo_filtro');
                } else {
                    $periodo_filtro = '0';
                }
                if ($this->session->userdata('cve_dependencia_filtro')) {
                    $cve_dependencia_filtro = $this->session->userdata('cve_dependencia_filtro');
                } else {
                    $cve_dependencia_filtro = $cve_dependencia;
                    if ($cve_rol != 'usr') {
                        $cve_dependencia_filtro = '%';
                    }
                }
                if ($this->session->userdata('tipo_evaluacion_filtro')) {
                    $tipo_evaluacion_filtro = $this->session->userdata('tipo_evaluacion_filtro');
                } else {
                    $tipo_evaluacion_filtro = '0';
                }
                if ($this->session->userdata('proyecto_evaluado_filtro')) {
                    $proyecto_evaluado_filtro = $this->session->userdata('proyecto_evaluado_filtro');
                } else {
                    $proyecto_evaluado_filtro = '';
                }
            }

            $data['periodo_filtro'] = $periodo_filtro;
            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;
            $data['tipo_evaluacion_filtro'] = $tipo_evaluacion_filtro;
            $data['proyecto_evaluado_filtro'] = $proyecto_evaluado_filtro;

            $data['periodos_filtro'] = $periodos;
            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, 0, 0, $anio_sesion);
            $data['tipos_evaluacion_filtro'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['eventos'] = $this->eventos_model->get_eventos($anio_sesion);
            $data['num_programas_evaluados'] = $this->propuestas_evaluacion_model->get_num_programas_evaluados($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['num_propuestas_evaluacion'] = $this->propuestas_evaluacion_model->get_num_propuestas_evaluacion($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['evaluaciones_ejercicio'] = $this->propuestas_evaluacion_model->get_evaluaciones_ejercicio($cve_dependencia_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['evaluaciones_tipo'] = $this->propuestas_evaluacion_model->get_evaluaciones_tipo($cve_dependencia_filtro, $periodo_filtro, $proyecto_evaluado_filtro);
            $data['evaluaciones'] = $this->propuestas_evaluacion_model->get_evaluaciones($periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);

            $data['num_recomendaciones'] = $this->recomendaciones_model->get_num_recomendaciones($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['num_recomendaciones_aceptadas'] = $this->recomendaciones_model->get_num_recomendaciones_aceptadas($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['num_recomendaciones_atendidas'] = $this->recomendaciones_model->get_num_recomendaciones_atendidas($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);
            $data['cumplimiento'] = $this->recomendaciones_model->get_cumplimiento($cve_dependencia_filtro, $periodo_filtro, $tipo_evaluacion_filtro, $proyecto_evaluado_filtro);

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
