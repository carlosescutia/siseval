<?php
class Proyectos extends CI_Controller {
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
        $this->load->model('programas_model');
        $this->load->model('evaluaciones_model');
        $this->load->model('dependencias_model');
        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('metas_ods_model');
        
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
            array_push($data['permisos_usuario'], 'planificacion.etapa_actual'); 
        }

        return $data;
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

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

            $data['dependencia'] = $this->dependencias_model->get_dependencia($cve_dependencia);
            $data['estadisticas_proyectos'] = $this->proyectos_model->get_estadisticas_proyectos_dependencia($cve_dependencia);

            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;
            $data['anexo_social'] = $anexo_social;
            $data['evaluaciones_propuestas'] = $evaluaciones_propuestas;

            $data['proyectos'] = $this->proyectos_model->get_proyectos_dependencia($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, 0, 0);
            $data['num_supervisores'] = $this->parametros_sistema_model->get_parametro_sistema_nom('num_supervisores');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('proyectos/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_proyecto)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['err_propuestas_evaluacion'] = $this->session->flashdata('err_propuestas_evaluacion');

            $data['proyecto'] = $this->proyectos_model->get_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);
            $cve_proyecto = $data['proyecto']['cve_proyecto'];
            $cve_anterior_proyecto = $data['proyecto']['cve_anterior_proyecto'];
            $data['programa'] = $this->programas_model->get_programa_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);
            $data['evaluaciones'] = $this->evaluaciones_model->get_evaluaciones_proyecto($cve_anterior_proyecto, $cve_dependencia, $cve_rol);
            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['propuestas_evaluacion'] = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($cve_proyecto);
            $data['num_propuestas_evaluacion_proyecto_dependencia'] = $this->propuestas_evaluacion_model->get_num_propuestas_evaluacion_proyecto_dependencia($cve_proyecto, $cve_dependencia);
            $data['anio_propuestas'] = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_propuestas');
            $data['metas'] = $this->metas_ods_model->get_metas_proyecto($cve_proyecto);
            $data['num_supervisores'] = $this->parametros_sistema_model->get_parametro_sistema_nom('num_supervisores');

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
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

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

                $periodo = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_propuestas');

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
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'proyectos';
                $valor = $cve_proyecto_nuevo . " " . $proyecto['nom_proyecto'];
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
            $propuestas = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($proyecto['cve_proyecto']);
            if ($propuestas) {
                $err_proyectos = array('cve_proyecto' => $proyecto['cve_proyecto'], 'error' => 'Este proyecto tiene propuestas de evaluación, no se puede eliminar');
                $this->session->set_flashdata('err_proyectos', $err_proyectos);
            } else {
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $accion = 'eliminó';
                $entidad = 'proyectos';
                $valor = $proyecto['cve_proyecto'] . " " . $proyecto['nom_proyecto'];
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

                // eliminado
                $this->proyectos_model->eliminar($id_proyecto);
            }
            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

}
