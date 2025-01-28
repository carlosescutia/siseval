<?php
class Reportes extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');
        $this->load->helper('file');
        $this->load->helper('download');

        $this->load->model('proyectos_model');
        $this->load->model('parametros_sistema_model');
        $this->load->model('dependencias_model');
        $this->load->model('probabilidades_inclusion_model');
        $this->load->model('evaluadores_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $periodos = $this->proyectos_model->get_anios_proyectos();
            $this->session->set_userdata('periodos', $periodos);
            $data['userdata'] = $this->session->userdata;

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_programas_agenda_evaluacion($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $salida = '';
            if ($this->input->post()) {
                $salida = $this->input->post('salida');
            }

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['programas_agenda_evaluacion'] = $this->proyectos_model->get_programas_agenda_evaluacion_reporte($cve_dependencia, $anio_sesion, $salida);

            if ($salida == 'csv') {
                force_download("programas_agenda_anual_evaluacion_" . $anio_sesion . ".csv", $data['programas_agenda_evaluacion']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_programas_agenda_evaluacion', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_propuestas_evaluacion($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $salida = '';
            if ($this->input->post()) {
                $salida = $this->input->post('salida');
            }

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['propuestas_evaluacion'] = $this->proyectos_model->get_propuestas_evaluacion($cve_dependencia, $anio_sesion, $salida);

            if ($salida == 'csv') {
                force_download("listado_propuestas_evaluacion_" . $anio_sesion . ".csv", $data['propuestas_evaluacion']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_propuestas_evaluacion', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_status_dependencias($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $filtros = $this->input->post();
            if ($filtros) {
                $evaluaciones = $filtros['evaluaciones'];
                $propuestas = $filtros['propuestas'];
            } else {
                $evaluaciones = '';
                $propuestas = '';
            }

            $data['evaluaciones'] = $evaluaciones;
            $data['propuestas'] = $propuestas;

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['status_dependencias'] = $this->dependencias_model->get_status_dependencias($evaluaciones, $propuestas, $anio_sesion, $salida);

            if ($salida == 'csv') {
                force_download("listado_status_dependencias_" . $anio_sesion . ".csv", $data['status_dependencias']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_status_dependencias', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_bitacora($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_rol = $data['userdata']['cve_rol'];

            $filtros = $this->input->post();
            if ($filtros) {
                $accion = $filtros['accion'];
                $entidad = $filtros['entidad'];
            } else {
                $accion = '';
                $entidad = '';
            }

            $data['accion'] = $accion;
            $data['entidad'] = $entidad;

            $nom_dependencia = $this->session->userdata['nom_dependencia'];
            $data['bitacora'] = $this->bitacora_model->get_bitacora($nom_dependencia, $cve_rol, $accion, $entidad, $salida);

            if ($salida == 'csv') {
                force_download("listado_bitacora_" . ".csv", $data['bitacora']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_bitacora', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_evaluadores($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;


            $data['evaluadores'] = $this->evaluadores_model->get_listado_evaluadores($salida);

            if ($salida == 'csv') {
                force_download("listado_evaluadores_" . ".csv", $data['evaluadores']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_evaluadores', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }


}
