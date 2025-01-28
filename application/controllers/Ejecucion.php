<?php
class Ejecucion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('proyectos_model');
        $this->load->model('dependencias_model');
        $this->load->model('propuestas_evaluacion_model');

        $this->etapa_modulo = 3;
        $this->nom_etapa_modulo = 'ejecucion.etapa_activa';
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
            $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion_ejecucion($cve_dependencia_filtro, $anio_sesion);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia_filtro, $anio_sesion);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia, $anio_sesion);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar_archivos');
            $this->load->view('ejecucion/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function urls($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $cve_dependencia, $cve_rol);
            $data['id_propuesta_evaluacion'] = $id_propuesta_evaluacion;

            $this->load->view('templates/header', $data);
            $this->load->view('ejecucion/urls', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar_urls()
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->input->post();
            if ($propuesta_evaluacion) {

                $id_propuesta_evaluacion = $propuesta_evaluacion['id_propuesta_evaluacion'];

                // guardado
                $data = array(
                    'url_sitio_if' => $propuesta_evaluacion['url_sitio_if'],
                    'url_arch_if' => $propuesta_evaluacion['url_arch_if'],
                    'url_sitio_fc' => $propuesta_evaluacion['url_sitio_fc'],
                    'url_arch_fc' => $propuesta_evaluacion['url_arch_fc'],
                );
                $id_propuesta_evaluacion = $this->propuestas_evaluacion_model->guardar($data, $id_propuesta_evaluacion);

                // registro en bitacora
                $entidad = 'propuestas_evaluacion';
                $accion = 'modificó';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('ejecucion');

        } else {
            redirect('inicio/login');
        }
    }

}
