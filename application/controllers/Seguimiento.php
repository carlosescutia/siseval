<?php
class Seguimiento extends CI_Controller {
    // globales
    var $etapa_actual;


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
        $this->load->model('documentos_opinion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('recomendaciones_model');
        $this->load->model('planes_accion_model');
        $this->load->model('status_plan_accion_model');
        $this->load->model('valoraciones_plan_accion_model');
        $this->load->model('actividades_model');

        // globales
        $this->etapa_actual = 5;
    }

    public function get_userdata()
    {
        $cve_usuario = $this->session->userdata('cve_usuario');
        $cve_rol = $this->session->userdata('cve_rol');
        $data['cve_usuario'] = $this->session->userdata('cve_usuario');
        $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
        $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
        $data['cve_rol'] = $cve_rol;
        $data['nom_usuario'] = $this->session->userdata('nom_usuario');
        $data['error'] = $this->session->flashdata('error');
        $data['permisos_usuario'] = explode(',', $this->accesos_sistema_model->get_permisos_usuario($cve_usuario));

        $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
        $data['etapa_siseval'] = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');
        if ($data['etapa_siseval'] == $this->etapa_actual) { 
            array_push($data['permisos_usuario'], 'seguimiento.etapa_actual'); 
        }

        return $data;
    }

    public function registro_bitacora($accion, $entidad, $valor)
    {
        // registro en bitacora
        $separador = ' -> ';
        $usuario = $this->session->userdata('usuario');
        $nom_usuario = $this->session->userdata('nom_usuario');
        $nom_dependencia = $this->session->userdata('nom_dependencia');
        $data = array(
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i"),
            'origen' => $_SERVER['REMOTE_ADDR'],
            'usuario' => $usuario,
            'nom_usuario' => $nom_usuario,
            'nom_dependencia' => $nom_dependencia,
            'accion' => $accion,
            'entidad' => $entidad,
            'valor' => $valor
        );
        $this->bitacora_model->guardar($data);
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

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

            $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion_plan_accion($cve_dependencia_filtro);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia_filtro);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia);

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
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

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
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

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
                $this->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'seguimiento/detalle/' . $id_plan_accion);
            }

        } else {
            redirect('inicio/login');
        }
    }

}
