<?php
class Gestion extends CI_Controller {

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
            $data['err_proyectos'] = $this->session->flashdata('err_proyectos');

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
                    if ($cve_rol == 'sup' or $cve_rol == 'adm') {
                        $cve_dependencia_filtro = '%';
                    }
                }
			}
                    $anexo_social = '0';
                    $evaluaciones_propuestas = '0';

            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;

            $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion($cve_dependencia_filtro);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            if ($cve_rol == 'sup' or $cve_rol == 'adm') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, 0, 0);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('gestion/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }


}
