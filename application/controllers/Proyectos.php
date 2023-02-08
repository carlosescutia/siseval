<?php
class Proyectos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');

        $this->load->model('proyectos_model');
        $this->load->model('programas_model');
        $this->load->model('evaluaciones_model');
        $this->load->model('dependencias_model');
        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('evaluaciones_actuales_model');
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

            $data['proyectos'] = $this->proyectos_model->get_proyectos_dependencia($cve_dependencia, $cve_rol);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, $cve_rol);

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
            $data['evaluacion_actual'] = $this->evaluaciones_actuales_model->get_evaluacion_actual_proyecto($cve_proyecto);
            if (! $data['evaluacion_actual']) {
                $data['evaluacion_actual'] = array (
                    'id_evaluacion_actual' => null,
                    'cve_proyecto' => $cve_proyecto,
                    'id_tipo_evaluacion' => null,
                    'otro_tipo_evaluacion' => null,
                    'id_justificacion_evaluacion' => null,
                    'otra_justificacion_evaluacion' => null,
                    'anios_ejecucion' => null,
                    'meses_duracion' => null,
                    'objetivo' => null,
                    'recursos_propios' => null,
                    'monto' => null,
                    'observaciones' => null
                );
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('proyectos/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

}
