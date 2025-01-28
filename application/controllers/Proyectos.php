<?php
class Proyectos extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('proyectos_model');
        $this->load->model('programas_model');
        $this->load->model('evaluaciones_model');
        $this->load->model('dependencias_model');
        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('metas_ods_model');
        $this->load->model('parametros_sistema_model');
        $this->load->model('periodos_model');

        $this->etapa_modulo = 1;
        $this->nom_etapa_modulo = 'planificacion.etapa_activa';
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

            $data['err_proyectos'] = $this->session->flashdata('err_proyectos');

            $filtros = $this->input->post();
            if ($filtros) {
                $cve_dependencia_filtro = $filtros['cve_dependencia_filtro'];
                $anexo_social = $filtros['anexo_social'];
                $evaluaciones_propuestas = $filtros['evaluaciones_propuestas'];
                $filtros_proyectos = array(
                    'cve_dependencia_filtro' => $cve_dependencia_filtro,
                    'anexo_social' => $anexo_social,
                    'evaluaciones_propuestas' => $evaluaciones_propuestas,
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
                if ($this->session->userdata('anexo_social')) {
                    $anexo_social = $this->session->userdata('anexo_social');
                } else {
                    $anexo_social = '0';
                }
                if ($this->session->userdata('evaluaciones_propuestas')) {
                    $evaluaciones_propuestas = $this->session->userdata('evaluaciones_propuestas');
                } else {
                    $evaluaciones_propuestas = '0';
                }
            }

            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;
            $data['anexo_social'] = $anexo_social;
            $data['evaluaciones_propuestas'] = $evaluaciones_propuestas;

            $anio_sesion = $this->session->userdata('anio_sesion');
            $data['proyectos'] = $this->proyectos_model->get_proyectos_dependencia($cve_dependencia_filtro, $anio_sesion, $anexo_social, $evaluaciones_propuestas);
            $data['dependencia'] = $this->dependencias_model->get_dependencia_periodo($cve_dependencia, $anio_sesion);
            $data['estadisticas_proyectos'] = $this->proyectos_model->get_estadisticas_proyectos_dependencia($cve_dependencia, $anio_sesion);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas, $anio_sesion);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, 0, 0, $anio_sesion);
            $data['num_supervisores'] = $this->periodos_model->get_periodo_nom_periodo($data['userdata']['anio_sesion'])['num_supervisores'];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('proyectos/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_proyecto)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $data['err_propuestas_evaluacion'] = $this->session->flashdata('err_propuestas_evaluacion');

            $data['proyecto'] = $this->proyectos_model->get_proyecto($id_proyecto, $cve_dependencia, $cve_rol);
            $cve_proyecto = $data['proyecto']['cve_proyecto'];
            $cve_anterior_proyecto = $data['proyecto']['cve_anterior_proyecto'];
            $periodo = $data['proyecto']['periodo'];

            $data['propuestas_evaluacion'] = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($id_proyecto);
            $data['evaluaciones'] = $this->evaluaciones_model->get_evaluaciones_proyecto($cve_anterior_proyecto, $periodo, $cve_dependencia, $cve_rol);
            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['metas'] = $this->metas_ods_model->get_metas_proyecto($cve_proyecto);
            $data['num_propuestas_evaluacion_proyecto_dependencia'] = $this->propuestas_evaluacion_model->get_num_propuestas_evaluacion_proyecto_dependencia($id_proyecto, $cve_dependencia);

            // Obtener un solo registro, se están generando varios
            $data['programa'] = $this->programas_model->get_programa_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);

            $data['num_supervisores'] = $this->periodos_model->get_periodo_nom_periodo($data['userdata']['anio_sesion'])['num_supervisores'];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('proyectos/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];

            $this->load->view('templates/header', $data);
            $this->load->view('proyectos/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_proyecto=null)
    {
        if ($this->session->userdata('logueado')) {

            $proyecto = $this->input->post();
            if ($proyecto) {

                if ($id_proyecto) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                $data = [];
                $periodo = $this->session->userdata['anio_sesion'];

                $cve_dependencia = $this->session->userdata('cve_dependencia');
                $reg_consecutivo = $this->proyectos_model->get_consecutivo_dependencia($cve_dependencia);
                $consecutivo = $reg_consecutivo['consecutivo'];
                $consecutivo++;
                $cve_proyecto_nuevo = 'P' . str_pad($cve_dependencia, 2, '0', STR_PAD_LEFT) . str_pad($consecutivo, 2, '0', STR_PAD_LEFT) ;

                // guardado
                $data = array(
                    'cve_proyecto' => $cve_proyecto_nuevo,
                    'nom_proyecto' => $proyecto['nom_proyecto'],
                    'cve_dependencia' => $cve_dependencia,
                    'periodo' => $periodo,
                    'presupuesto_aprobado' => empty($proyecto['presupuesto_aprobado']) ? null : $proyecto['presupuesto_aprobado'],
                    'cve_tipo_gasto' => $proyecto['cve_tipo_gasto'],
                    'cve_programa' => $proyecto['cve_programa']
                );
                $id_proyecto = $this->proyectos_model->guardar($data, $id_proyecto);

                // registro en bitacora
                $entidad = 'proyectos';
                $valor = $cve_proyecto_nuevo . " " . $proyecto['nom_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_proyecto)
    {
        if ($this->session->userdata('logueado')) {

            $cve_rol = $this->session->userdata('cve_rol');
            $cve_dependencia = $this->session->userdata('cve_dependencia');
            $proyecto = $this->proyectos_model->get_proyecto_id($id_proyecto);
            $propuestas = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($proyecto['id_proyecto']);
            if ($propuestas) {
                $err_proyectos = array('cve_proyecto' => $proyecto['cve_proyecto'], 'error' => 'Este proyecto tiene propuestas de evaluación, no se puede eliminar');
                $this->session->set_flashdata('err_proyectos', $err_proyectos);
            } else {
                // registro en bitacora
                $accion = 'eliminó';
                $entidad = 'proyectos';
                $valor = $proyecto['cve_proyecto'] . " " . $proyecto['nom_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                // eliminado
                $this->proyectos_model->eliminar($id_proyecto);
            }
            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

}
