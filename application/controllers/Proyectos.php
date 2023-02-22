<?php
class Proyectos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');

        $this->load->model('proyectos_model');
        $this->load->model('programas_model');
        $this->load->model('evaluaciones_model');
        $this->load->model('dependencias_model');
        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
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

            $filtros = $this->input->post();
            if ($filtros) {
                $cve_dependencia_filtro = $filtros['cve_dependencia_filtro'];
                $anexo_social = $filtros['anexo_social'];
                $evaluaciones_propuestas = $filtros['evaluaciones_propuestas'];
            } else {
                $cve_dependencia_filtro = $cve_dependencia;
                if ($cve_rol == 'sup') {
                    $cve_dependencia_filtro = '%';
                }
                $anexo_social = '0';
                $evaluaciones_propuestas = '0';
			}
            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;
            $data['anexo_social'] = $anexo_social;
            $data['evaluaciones_propuestas'] = $evaluaciones_propuestas;

            $data['proyectos'] = $this->proyectos_model->get_proyectos_dependencia($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro);
            if ($cve_rol == 'sup' or $cve_rol == 'adm') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia);

            $this->load->view('templates/header', $data);
            $this->load->view('proyectos/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_proyecto)
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

            $data['proyecto'] = $this->proyectos_model->get_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);
            $cve_anterior_proyecto = $data['proyecto']['cve_anterior_proyecto'];
            $data['programa'] = $this->programas_model->get_programa_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);
            $data['evaluaciones'] = $this->evaluaciones_model->get_evaluaciones_proyecto($cve_anterior_proyecto, $cve_dependencia, $cve_rol);
            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['propuestas_evaluacion'] = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($cve_proyecto);
            $data['num_propuestas_evaluacion_proyecto_dependencia'] = $this->propuestas_evaluacion_model->get_num_propuestas_evaluacion_proyecto_dependencia($cve_proyecto, $cve_dependencia);
            $data['parametros_sistema'] = $this->parametros_sistema_model->get_parametros_sistema();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('proyectos/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

}
