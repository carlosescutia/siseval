<?php
class Evaluaciones extends CI_Controller {
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

        $this->load->model('evaluaciones_model');
        $this->load->model('proyectos_model');
        
        // globales
        $this->etapa_actual = 1;
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
            array_push($data['permisos_usuario'], 'es_etapa_actual'); 
        }

        return $data;
    }

    public function detalle($id_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['evaluacion'] = $this->evaluaciones_model->get_evaluacion($id_evaluacion, $cve_dependencia, $cve_rol);
            $cve_anterior_proyecto = $data['evaluacion']['cve_proyecto'];
            $data['proyecto'] = $this->proyectos_model->get_proyecto_anterior($cve_anterior_proyecto, $cve_dependencia, $cve_rol);

            $this->load->view('templates/header', $data);
            $this->load->view('evaluaciones/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

}
