<?php
class Seguimiento extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('proyectos_model');
        $this->load->model('dependencias_model');
        $this->load->model('documentos_opinion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('recomendaciones_model');
        $this->load->model('planes_accion_model');
        $this->load->model('status_plan_accion_model');
        $this->load->model('valoraciones_plan_accion_model');
        $this->load->model('actividades_model');

        // globales
        $this->etapa_modulo = 5;
        $this->nom_etapa_modulo = 'seguimiento.etapa_activa';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $periodos = $this->proyectos_model->get_anios_proyectos();
            $this->session->set_userdata('periodos', $periodos);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];
            $data['error'] = $this->session->flashdata('error');

            $filtros = $this->input->post();
            if ($filtros) {
                $cve_dependencia_filtro = $filtros['cve_dependencia_filtro'];
                $filtros_proyectos = array(
                    'cve_dependencia_filtro' => $cve_dependencia_filtro,
                );
                $this->session->set_userdata($filtros_proyectos);
            } else {
                if ($this->session->userdata('cve_dependencia_filtro')) {
                    $cve_dependencia_filtro = $this->session->userdata('cve_dependencia_filtro');
                } else {
                    $cve_dependencia_filtro = $cve_dependencia;
                    if ($cve_rol != 'usr') {
                        $cve_dependencia_filtro = '%';
                    }
                }
            }
            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion_plan_accion($cve_dependencia_filtro, $anio_sesion);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia_filtro, $anio_sesion);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia, $anio_sesion);

            $this->load->view('templates/header', $data);
            $this->load->view('seguimiento/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_plan_accion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $data['recomendaciones'] = $this->recomendaciones_model->get_recomendaciones_plan_accion($id_plan_accion);
            $data['actividades'] = $this->actividades_model->get_actividades_plan_accion($id_plan_accion);
            $data['proyecto'] = $this->proyectos_model->get_proyecto_plan_accion($id_plan_accion);

            $this->load->view('templates/header', $data);
            $this->load->view('seguimiento/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function actividades_detalle($id_actividad)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $data['actividad'] = $this->actividades_model->get_actividad($id_actividad);
            $data['plan_accion'] = $this->planes_accion_model->get_plan_accion_actividad($id_actividad);

            $this->load->view('templates/header', $data);
            $this->load->view('seguimiento/actividades_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function avance_guardar()
    {
        if ($this->session->userdata('logueado')) {
            // guardado

            $actividad = $this->input->post();
            $id_plan_accion = $actividad['id_plan_accion'] ;
            $id_actividad = $actividad['id_actividad'] ;
            if ($actividad) {
                $data = array(
                    'registro_avance' => $actividad['registro_avance'],
                    'comentarios_avance' => $actividad['comentarios_avance'],
                );
                $this->actividades_model->guardar($data, $id_actividad);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'actividades';
                $valor = 'actividad ' . $id_actividad;
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'seguimiento/detalle/' . $id_plan_accion);
            }

        } else {
            redirect('inicio/login');
        }
    }

}
