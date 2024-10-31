<?php
class Valoracion extends CI_Controller {
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
        $this->load->model('tipos_actor_model');
        $this->load->model('status_documentos_opinion_model');
        $this->load->model('valoraciones_recomendacion_model');
        $this->load->model('planes_accion_model');
        $this->load->model('status_plan_accion_model');
        $this->load->model('valoraciones_plan_accion_model');
        $this->load->model('actividades_model');
        $this->load->model('valoraciones_evaluador_model');
        $this->load->model('valoraciones_evaluacion_model');
        $this->load->model('evaluadores_model');

        // globales
        $this->etapa_actual = 4;
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
            array_push($data['permisos_usuario'], 'valoracion.etapa_actual'); 
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

            $data['proyectos'] = $this->proyectos_model->get_programas_agenda_evaluacion($cve_dependencia_filtro);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia_filtro);
            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $data['status_documentos_opinion'] = $this->status_documentos_opinion_model->get_status_documentos_opinion();

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_evaluaciones($cve_dependencia);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar_archivos');
            $this->load->view('valoracion/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    /*
    * Documento de opinion
    */
    public function documento_opinion_detalle($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['documento_opinion'] = $this->documentos_opinion_model->get_documento_opinion($cve_documento_opinion);
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion_doc_op($cve_documento_opinion);
            $data['recomendaciones'] = $this->recomendaciones_model->get_recomendaciones_doc_op($cve_documento_opinion);
            $data['tipos_actor'] = $this->tipos_actor_model->get_tipos_actor();
            $data['status_documentos_opinion'] = $this->status_documentos_opinion_model->get_status_documentos_opinion();
            $data['valoraciones_recomendacion'] = $this->valoraciones_recomendacion_model->get_valoraciones_recomendacion_documento_opinion($cve_documento_opinion);
            $data['error_recomendaciones'] = $this->session->flashdata('error_recomendaciones');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/documento_opinion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function documento_opinion_nuevo($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {


            // guardado
            $data = array(
                'id_propuesta_evaluacion' => $id_propuesta_evaluacion,
                'fecha_elaboracion' => date('Y-m-d'),
                'status' => 'en_proceso',
            );
            $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'documentos_opinion';
            $valor = 'doc_op ' . $cve_documento_opinion . ' nuevo';
            $this->registro_bitacora($accion, $entidad, $valor);

            $this->documento_opinion_detalle($cve_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function documento_opinion_revision($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            // guardado
            $data = array(
                'fecha_elaboracion' => date('Y-m-d'),
                'status' => 'por_evaluar',
            );
            $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, $cve_documento_opinion);

            // cambiar status a "por_evaluar" en valoraciones con observaciones del documento de opinion
            $status = 'por_evaluar';
            $this->valoraciones_recomendacion_model->set_status_documento_opinion($cve_documento_opinion, $status);

            // registro en bitacora
            $accion = 'modificó';
            $entidad = 'documentos_opinion';
            $valor = 'doc_op ' . $cve_documento_opinion . ' revision';
            $this->registro_bitacora($accion, $entidad, $valor);

            redirect('valoracion');

        } else {
            redirect('inicio/login');
        }
    }

    public function documento_opinion_guardar($cve_documento_opinion=null)
    {
        if ($this->session->userdata('logueado')) {

            $documento_opinion = $this->input->post();
            if ($documento_opinion) {

                // guardado
                $data = array(
                    'fecha_elaboracion' => $documento_opinion['fecha_elaboracion'],
                    'instancia_evaluadora' => $documento_opinion['instancia_evaluadora'],
                    'elaborado_por' => $documento_opinion['elaborado_por'],
                    'antecedentes' => $documento_opinion['antecedentes'],
                );
                $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, $cve_documento_opinion);

                // registro en bitacora
                if ($cve_documento_opinion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                $entidad = 'documentos_opinion';
                $valor = $cve_documento_opinion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/documento_opinion_detalle/' . $cve_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function recomendaciones_nuevo($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            // guardado
            $data = array(
                'cve_documento_opinion' => $cve_documento_opinion,
            );
            $cve_recomendacion = $this->recomendaciones_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'recomendaciones';
            $valor = $cve_recomendacion;
            $this->registro_bitacora($accion, $entidad, $valor);

            redirect('valoracion/documento_opinion_detalle/' . $cve_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function recomendaciones_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $recomendacion = $this->input->post();
            if ($recomendacion) {

                // guardado
                $data = array(
                    'cve_documento_opinion' => $recomendacion['cve_documento_opinion'],
                    'desc_recomendacion' => $recomendacion['desc_recomendacion'],
                    'clara' => $recomendacion['clara'],
                    'relevante' => $recomendacion['relevante'],
                    'justificable' => $recomendacion['justificable'],
                    'factible' => $recomendacion['factible'],
                    'id_tipo_actor' => empty($recomendacion['id_tipo_actor']) ? null : $recomendacion['id_tipo_actor'],
                    'prioridad' => $recomendacion['prioridad'],
                    'responsable' => $recomendacion['responsable'],
                    'postura' => $recomendacion['postura'],
                    'justificacion' => $recomendacion['justificacion'],
                );
                $cve_recomendacion = $this->recomendaciones_model->guardar($data, $recomendacion['cve_recomendacion']);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'recomendaciones';
                $valor = $cve_recomendacion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/documento_opinion_detalle/' . $recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function recomendaciones_ponderacion()
    {
        if ($this->session->userdata('logueado')) {

            $recomendacion = $this->input->post();
            if ($recomendacion) {

                // guardado
                $data = array(
                    'ponderacion' => $recomendacion['ponderacion'],
                );
                $cve_recomendacion = $this->recomendaciones_model->guardar($data, $recomendacion['cve_recomendacion']);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'recomendaciones';
                $valor = $cve_recomendacion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/plan_accion_detalle/' . $recomendacion['id_plan_accion']);

        } else {
            redirect('inicio/login');
        }
    }


    public function recomendaciones_eliminar($cve_recomendacion)
    {
        if ($this->session->userdata('logueado')) {

            $recomendacion = $this->recomendaciones_model->get_recomendacion($cve_recomendacion);
            $num_valoraciones = $this->valoraciones_recomendacion_model->get_num_valoraciones_recomendacion($cve_recomendacion);

            if ($num_valoraciones == 0) {
                // eliminado
                $this->recomendaciones_model->eliminar($cve_recomendacion);

                // registro en bitacora
                $accion = 'eliminó';
                $entidad = 'recomendaciones';
                $valor = "Recomendacion ". $cve_recomendacion;
                $this->registro_bitacora($accion, $entidad, $valor);

            } else {
                $this->session->set_flashdata('error_recomendaciones', 'No se puede eliminar la recomendación porque ya tiene Valoraciones.');
            }
            redirect('valoracion/documento_opinion_detalle/' . $recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_recomendacion_detalle($cve_valoracion_recomendacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_recomendacion'] = $this->valoraciones_recomendacion_model->get_valoracion_recomendacion($cve_valoracion_recomendacion);
            $data['documento_opinion'] = $this->documentos_opinion_model->get_documento_opinion($data['valoracion_recomendacion']['cve_documento_opinion']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/valoracion_recomendacion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_recomendacion_nuevo()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_recomendacion = $this->input->post();
            if ($valoracion_recomendacion) {

                // guardado
                $data = array(
                    'cve_recomendacion' => $valoracion_recomendacion['cve_recomendacion'],
                    'cve_dependencia' => $this->session->userdata('cve_dependencia'),
                    'status' => 'por_evaluar',
                );
                $cve_valoracion_recomendacion = $this->valoraciones_recomendacion_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'valoraciones_recomendacion';
                $valor = 'doc_op ' . $cve_valoracion_recomendacion . ' nuevo';
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            $this->valoracion_recomendacion_detalle($cve_valoracion_recomendacion);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_recomendacion_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_recomendacion = $this->input->post();
            if ($valoracion_recomendacion) {

                // guardado
                $data = array(
                    'pertinencia' => $valoracion_recomendacion['pertinencia'],
                    'prioridad' => $valoracion_recomendacion['prioridad'],
                    'fundamentada' => $valoracion_recomendacion['fundamentada'],
                    'observaciones' => $valoracion_recomendacion['observaciones'],
                    'status' => 'valorada',
                );
                $cve_valoracion_recomendacion = $this->valoraciones_recomendacion_model->guardar($data, $valoracion_recomendacion['cve_valoracion_recomendacion']);

                $cve_documento_opinion = $valoracion_recomendacion['cve_documento_opinion'];
                $num_valoraciones_documento_opinion = $this->valoraciones_recomendacion_model->get_num_valoraciones_documento_opinion($cve_documento_opinion);
                $status_valoraciones_documento_opinion = $this->valoraciones_recomendacion_model->get_status_valoraciones_documento_opinion($cve_documento_opinion);
                // probar si se completaron las valoraciones solamente si todas las valoraciones tienen status valorada
                $num_supervisores = $this->parametros_sistema_model->get_parametro_sistema_nom('num_supervisores');
                $num_recomendaciones = $this->recomendaciones_model->get_num_recomendaciones_documento_opinion($cve_documento_opinion);
                if ($num_valoraciones_documento_opinion == ($num_supervisores * $num_recomendaciones) and $status_valoraciones_documento_opinion == 'valorada') {

                    // probar si no hay observaciones
                    $observaciones_valoraciones_documento_opinion = $this->valoraciones_recomendacion_model->get_observaciones_valoraciones_documento_opinion($cve_documento_opinion);
                    if ($observaciones_valoraciones_documento_opinion) {
                        // cambiar status del documento de opinion a en_proceso
                        $status = 'en_proceso';
                    } else {
                        // cambiar status del documento de opinion a aprobado
                        $status = 'aprobado';
                    }
                    $data = array(
                        'status' => $status,
                    );
                    $this->documentos_opinion_model->guardar($data, $cve_documento_opinion);

                }

                // registro en bitacora
                if ($valoracion_recomendacion['cve_valoracion_recomendacion']) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                $entidad = 'valoraciones_recomendacion';
                $valor = $cve_valoracion_recomendacion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/documento_opinion_detalle/' . $valoracion_recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_recomendacion_eliminar($cve_valoracion_recomendacion)
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_recomendacion = $this->valoraciones_recomendacion_model->get_valoracion_recomendacion($cve_valoracion_recomendacion);

            // eliminado
            $this->valoraciones_recomendacion_model->eliminar($cve_valoracion_recomendacion);
            //
            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'valoraciones_recomendacion';
            $valor = "valoracion_recomendacion ". $cve_valoracion_recomendacion;
            $this->registro_bitacora($accion, $entidad, $valor);

            redirect('valoracion/documento_opinion_detalle/' . $valoracion_recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    /*
    * /Documento de opinion
    */



    /*
    * Plan de acción
    */

    public function plan_accion_detalle($id_plan_accion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['plan_accion'] = $this->planes_accion_model->get_plan_accion($id_plan_accion);
            $cve_documento_opinion = $data['plan_accion']['cve_documento_opinion'];
            $data['status_plan_accion_all'] = $this->status_plan_accion_model->get_status_plan_accion_all();
            $data['documento_opinion'] = $this->documentos_opinion_model->get_documento_opinion($cve_documento_opinion);
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion_doc_op($cve_documento_opinion);
            $data['valoraciones_plan_accion'] = $this->valoraciones_plan_accion_model->get_valoraciones_plan_accion($id_plan_accion);
            $data['actividades'] = $this->actividades_model->get_actividades_plan_accion($id_plan_accion);
            $data['recomendaciones'] = $this->recomendaciones_model->get_recomendaciones_plan_accion($id_plan_accion);
            $data['recomendaciones_tienen_actividad'] = $this->actividades_model->get_recomendaciones_tienen_actividad($id_plan_accion);
            $data['num_valoraciones_plan_accion_dependencia'] = $this->valoraciones_plan_accion_model->get_num_valoraciones_plan_accion_dependencia($id_plan_accion, $cve_dependencia);
            $data['error_ponderaciones'] = $this->session->flashdata('error_ponderaciones');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/plan_accion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function plan_accion_nuevo($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            // guardado
            $data = array(
                'cve_documento_opinion' => $cve_documento_opinion,
                'fecha_elaboracion' => date('Y-m-d'),
                'status' => 'en_proceso',
            );
            $id_plan_accion = $this->planes_accion_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'planes_accion';
            $valor = 'plan_acc ' . $id_plan_accion;
            $this->registro_bitacora($accion, $entidad, $valor);

            $this->plan_accion_detalle($id_plan_accion);

        } else {
            redirect('inicio/login');
        }
    }

    public function plan_accion_revision($id_plan_accion)
    {
        if ($this->session->userdata('logueado')) {

            $ponderacion_recomendaciones = $this->recomendaciones_model->get_ponderacion_recomendaciones_plan_accion($id_plan_accion);
            $ponderacion_actividades = $this->actividades_model->get_ponderacion_actividades_plan_accion($id_plan_accion);

            if ($ponderacion_recomendaciones == 100 and $ponderacion_actividades == 100) {

                // guardado
                $data = array(
                    'fecha_elaboracion' => date('Y-m-d'),
                    'status' => 'por_evaluar',
                );
                $id_plan_accion = $this->planes_accion_model->guardar($data, $id_plan_accion);

                // cambiar status a "por_evaluar" en valoraciones con observaciones del documento de opinion
                $status = 'por_evaluar';
                $this->valoraciones_plan_accion_model->set_status_plan_accion($id_plan_accion, $status);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'planes_accion';
                $valor = 'plan_accion ' . $id_plan_accion . ' revision';
                $this->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'valoracion');
            } else {
                $this->session->set_flashdata('error_ponderaciones', 'La ponderación de las recomendaciones o de las actividades es diferente a 100');
                redirect(base_url() . 'valoracion/plan_accion_detalle/' . $id_plan_accion);
            }

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
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/actividades_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function actividades_nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $datos = $this->input->post();
            if ($datos) {
                $data['id_plan_accion'] = $datos['id_plan_accion'];
                $data['cve_recomendacion'] = $datos['cve_recomendacion'];

                $this->load->view('templates/header', $data);
                $this->load->view('valoracion/actividades_nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function actividades_guardar()
    {
        if ($this->session->userdata('logueado')) {
            // guardado

            $actividad = $this->input->post();
            $id_plan_accion = $actividad['id_plan_accion'] ;
            if ($actividad) {

                $id_actividad = $actividad['id_actividad'] ;
                if ($id_actividad) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                $data = array(
                    'cve_recomendacion' => $actividad['cve_recomendacion'],
                    'desc_actividad' =>  $actividad['desc_actividad'],
                    'fech_ini' =>  $actividad['fech_ini'],
                    'fech_fin' =>  $actividad['fech_fin'],
                    'area_responsable' => $actividad['area_responsable'],
                    'resultados_esperados' => $actividad['resultados_esperados'],
                    'ponderacion' => $actividad['ponderacion'],
                    'unidad_medida' => $actividad['unidad_medida'],
                );
                $id_actividad = $this->actividades_model->guardar($data, $id_actividad);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'actividades';
                $valor = 'actividad ' . $id_actividad;
                $this->registro_bitacora($accion, $entidad, $valor);

                redirect(base_url() . 'valoracion/plan_accion_detalle/' . $id_plan_accion);
            }

        } else {
            redirect('inicio/login');
        }
    }

    public function actividades_eliminar($id_actividad)
    {
        if ($this->session->userdata('logueado')) {

            $actividad = $this->actividades_model->get_actividad($id_actividad);
            if ($actividad) {

                // checar: mover despues de la eliminacion
                // registro en bitacora
                $accion = 'eliminó';
                $entidad = 'actividades';
                $valor = "Actividad ". $id_actividad;
                $this->registro_bitacora($accion, $entidad, $valor);

                // eliminado
                $this->actividades_model->eliminar($id_actividad);

                redirect(base_url() . 'valoracion/plan_accion_detalle/' . $actividad['id_plan_accion']);
            }

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_plan_accion_detalle($id_valoracion_plan_accion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_plan_accion'] = $this->valoraciones_plan_accion_model->get_valoracion_plan_accion($id_valoracion_plan_accion);
            $data['plan_accion'] = $this->planes_accion_model->get_plan_accion($data['valoracion_plan_accion']['id_plan_accion']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/valoracion_plan_accion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_plan_accion_nuevo()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_plan_accion = $this->input->post();
            if ($valoracion_plan_accion) {

                // guardado
                $data = array(
                    'id_plan_accion' => $valoracion_plan_accion['id_plan_accion'],
                    'cve_dependencia' => $this->session->userdata('cve_dependencia'),
                    'actividades_cumplimiento' => $this->session->userdata('actividades_cumplimiento'),
                    'plazo_adecuado' => $this->session->userdata('plazo_adecuado'),
                    'resultados_pertinentes' => $this->session->userdata('resultados_pertinentes'),
                    'observaciones' => $this->session->userdata('observaciones'),
                    'status' => 'por_evaluar',
                );
                $id_valoracion_plan_accion = $this->valoraciones_plan_accion_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'valoraciones_plan_accion';
                $valor = 'valoracion_plan_acc ' . $id_valoracion_plan_accion . ' nuevo';
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            $this->valoracion_plan_accion_detalle($id_valoracion_plan_accion);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_plan_accion_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_plan_accion = $this->input->post();
            if ($valoracion_plan_accion) {

                // guardado
                $data = array(
                    'actividades_cumplimiento' => $valoracion_plan_accion['actividades_cumplimiento'],
                    'plazo_adecuado' => $valoracion_plan_accion['plazo_adecuado'],
                    'resultados_pertinentes' => $valoracion_plan_accion['resultados_pertinentes'],
                    'observaciones' => $valoracion_plan_accion['observaciones'],
                    'status' => 'valorada',
                );
                $id_valoracion_plan_accion = $this->valoraciones_plan_accion_model->guardar($data, $valoracion_plan_accion['id_valoracion_plan_accion']);

                $id_plan_accion = $valoracion_plan_accion['id_plan_accion'];
                $num_valoraciones_plan_accion = $this->valoraciones_plan_accion_model->get_num_valoraciones_plan_accion($id_plan_accion);
                $status_valoraciones_plan_accion = $this->valoraciones_plan_accion_model->get_status_valoraciones_plan_accion($id_plan_accion);
                // probar si se completaron las valoraciones solamente si todas las valoraciones tienen status valorada
                $num_supervisores = $this->parametros_sistema_model->get_parametro_sistema_nom('num_supervisores');
                if ($num_valoraciones_plan_accion == $num_supervisores and $status_valoraciones_plan_accion == 'valorada') {

                    // probar si no hay observaciones
                    $observaciones_valoraciones_plan_accion = $this->valoraciones_plan_accion_model->get_observaciones_valoraciones_plan_accion($id_plan_accion);
                    if ($observaciones_valoraciones_plan_accion) {
                        // cambiar status del plan_accion a en_proceso
                        $status = 'en_proceso';
                    } else {
                        // cambiar status del plan_accion a aprobado
                        $status = 'aprobado';
                    }
                    $data = array(
                        'status' => $status,
                    );
                    $this->planes_accion_model->guardar($data, $id_plan_accion);

                }

                // registro en bitacora
                if ($valoracion_plan_accion['id_valoracion_plan_accion']) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                $entidad = 'valoraciones_plan_accion';
                $valor = $id_valoracion_plan_accion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/plan_accion_detalle/' . $valoracion_plan_accion['id_plan_accion']);

        } else {
            redirect('inicio/login');
        }
    }


    /*
    * /Plan de acción
    */



    /*
    * Valoración del evaluador
    */

    public function valoracion_evaluador_detalle($id_valoracion_evaluador)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_evaluador'] = $this->valoraciones_evaluador_model->get_valoracion_evaluador($id_valoracion_evaluador);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/valoracion_evaluador_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluador_nuevo($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {


            // guardado
            $data = array(
                'id_propuesta_evaluacion' => $id_propuesta_evaluacion,
            );
            $id_valoracion_evaluador = $this->valoraciones_evaluador_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'valoraciones_evaluador';
            $valor = 'valoracion evaluador ' . $id_valoracion_evaluador . ' nuevo';
            $this->registro_bitacora($accion, $entidad, $valor);

            $this->valoracion_evaluador_detalle($id_valoracion_evaluador);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluador_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_evaluador = $this->input->post();
            if ($valoracion_evaluador) {

                // guardado
                $data = array(
                    'id_evaluador' => $valoracion_evaluador['id_evaluador'],
                    'puntualidad' => $valoracion_evaluador['puntualidad'],
                    'solidez' => $valoracion_evaluador['solidez'],
                    'objetividad' => $valoracion_evaluador['objetividad'],
                    'claridad' => $valoracion_evaluador['claridad'],
                    'disponibilidad' => $valoracion_evaluador['disponibilidad'],
                    'observaciones' => $valoracion_evaluador['observaciones'],
                    'elaborado' => $valoracion_evaluador['elaborado'],
                    'cargo' => $valoracion_evaluador['cargo'],
                );
                $id_valoracion_evaluador = $this->valoraciones_evaluador_model->guardar($data, $valoracion_evaluador['id_valoracion_evaluador']);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'valoraciones_evaluador';
                $valor = $id_valoracion_evaluador;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect(base_url() . 'valoracion/valoracion_evaluador_detalle/' . $id_valoracion_evaluador);

        } else {
            redirect('inicio/login');
        }
    }

    public function frm_valoracion_evaluador($id_valoracion_evaluador)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_evaluador'] = $this->valoraciones_evaluador_model->get_valoracion_evaluador($id_valoracion_evaluador);

            $this->load->view('templates/header', $data);
            $this->load->view('valoracion/frm_valoracion_evaluador', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluador_seleccionar_evaluador($id_valoracion_evaluador)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $filtros = $this->input->post();
            if ($filtros) {
                $buscar_evaluador = $filtros['buscar_evaluador'];
            } else {
                $buscar_evaluador = '';
            }

            $data['buscar_evaluador'] = $buscar_evaluador;

            $data['evaluadores'] = $this->evaluadores_model->get_evaluadores_busqueda($buscar_evaluador);
            $data['valoracion_evaluador'] = $this->valoraciones_evaluador_model->get_valoracion_evaluador($id_valoracion_evaluador);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/seleccionar_evaluador', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluador_actualizar_evaluador()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_evaluador = $this->input->post();
            if ($valoracion_evaluador) {

                // guardado
                $data = array(
                    'id_evaluador' => $valoracion_evaluador['id_evaluador'],
                );
                $id_valoracion_evaluador = $this->valoraciones_evaluador_model->guardar($data, $valoracion_evaluador['id_valoracion_evaluador']);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'valoraciones_evaluador';
                $valor = $id_valoracion_evaluador;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect(base_url() . 'valoracion/valoracion_evaluador_detalle/' . $id_valoracion_evaluador);

        } else {
            redirect('inicio/login');
        }
    }

    /*
    * /Valoración del evaluador
    */




    /*
    * Valoración de la evaluación
    */

    public function valoracion_evaluacion_detalle($id_valoracion_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_evaluacion'] = $this->valoraciones_evaluacion_model->get_valoracion_evaluacion($id_valoracion_evaluacion);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/valoracion_evaluacion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluacion_nuevo($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {


            // guardado
            $data = array(
                'id_propuesta_evaluacion' => $id_propuesta_evaluacion,
            );
            $id_valoracion_evaluacion = $this->valoraciones_evaluacion_model->guardar($data, null);

            // registro en bitacora
            $accion = 'agregó';
            $entidad = 'valoraciones_evaluacion';
            $valor = 'valoracion evaluador ' . $id_valoracion_evaluacion . ' nuevo';
            $this->registro_bitacora($accion, $entidad, $valor);

            $this->valoracion_evaluacion_detalle($id_valoracion_evaluacion);

        } else {
            redirect('inicio/login');
        }
    }

    public function frm_valoracion_evaluacion($id_valoracion_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_evaluacion'] = $this->valoraciones_evaluacion_model->get_valoracion_evaluacion($id_valoracion_evaluacion);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/frm_valoracion_evaluacion', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_evaluacion_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_evaluacion = $this->input->post();
            if ($valoracion_evaluacion) {

                // guardado
                $data = array(
                    'informe' => $valoracion_evaluacion['informe'],
                    'antecedentes' => $valoracion_evaluacion['antecedentes'],
                    'metodologia' => $valoracion_evaluacion['metodologia'],
                    'informacion' => $valoracion_evaluacion['informacion'],
                    'analisis' => $valoracion_evaluacion['analisis'],
                    'conclusiones' => $valoracion_evaluacion['conclusiones'],
                    'acuerdos_institucionales' => $valoracion_evaluacion['acuerdos_institucionales'],
                    'acuerdos_confidencialidad' => $valoracion_evaluacion['acuerdos_confidencialidad'],
                    'derechos' => $valoracion_evaluacion['derechos'],
                    'orientacion' => $valoracion_evaluacion['orientacion'],
                    'autonomia' => $valoracion_evaluacion['autonomia'],
                    'genero' => $valoracion_evaluacion['genero'],
                    'observaciones' => $valoracion_evaluacion['observaciones'],
                    'evaluador' => $valoracion_evaluacion['evaluador'],
                    'elaborado' => $valoracion_evaluacion['elaborado'],
                    'cargo' => $valoracion_evaluacion['cargo'],
                );
                $id_valoracion_evaluacion = $this->valoraciones_evaluacion_model->guardar($data, $valoracion_evaluacion['id_valoracion_evaluacion']);

                // registro en bitacora
                $accion = 'modificó';
                $entidad = 'valoraciones_evaluacion';
                $valor = $id_valoracion_evaluacion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect(base_url() . 'valoracion/valoracion_evaluacion_detalle/' . $valoracion_evaluacion['id_valoracion_evaluacion']);

        } else {
            redirect('inicio/login');
        }
    }

    /*
    * /Valoración de la evaluación
    */

}
