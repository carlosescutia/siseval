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
        $this->load->model('status_documentos_opinion_model');
        $this->load->model('valoraciones_documento_opinion_model');

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
            $data['status_documentos_opinion'] = $this->status_documentos_opinion_model->get_status_documentos_opinion();
            $data['valoraciones_documento_opinion'] = $this->valoraciones_documento_opinion_model->get_valoraciones_documento_opinion($cve_documento_opinion);
            $data['num_valoraciones_documento_opinion_dependencia'] = $this->valoraciones_documento_opinion_model->get_num_valoraciones_documento_opinion_dependencia($cve_documento_opinion, $cve_dependencia);

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

            // cambiar status a valoraciones con observaciones del documento de opinion a por_valorar
            $data = array(
                'status' => 'por_valorar',
            );
            $this->valoraciones_documento_opinion_model->guardar_documento_opinion($data, $cve_documento_opinion);

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

    public function recomendaciones_eliminar($cve_recomendacion)
    {
        if ($this->session->userdata('logueado')) {

            // checar: al parecer no se usa
            $recomendacion = $this->recomendaciones_model->get_recomendacion($cve_recomendacion);

            // checar: mover despues de la eliminacion
            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'recomendaciones';
            $valor = "Recomendacion ". $cve_recomendacion;
            $this->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->recomendaciones_model->eliminar($cve_recomendacion);

            redirect('valoracion/documento_opinion_detalle/' . $recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_documento_opinion_detalle($cve_valoracion_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['valoracion_documento_opinion'] = $this->valoraciones_documento_opinion_model->get_valoracion_documento_opinion($cve_valoracion_documento_opinion);
            $data['documento_opinion'] = $this->documentos_opinion_model->get_documento_opinion($data['valoracion_documento_opinion']['cve_documento_opinion']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('valoracion/valoracion_documento_opinion_detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_documento_opinion_nuevo()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_documento_opinion = $this->input->post();
            if ($valoracion_documento_opinion) {

                // guardado
                $data = array(
                    'cve_documento_opinion' => $valoracion_documento_opinion['cve_documento_opinion'],
                    'cve_dependencia' => $this->session->userdata('cve_dependencia'),
                    'status' => 'por_valorar',
                );
                $cve_valoracion_documento_opinion = $this->valoraciones_documento_opinion_model->guardar($data, null);

                // registro en bitacora
                $accion = 'agregó';
                $entidad = 'valoraciones_documento_opinion';
                $valor = 'doc_op ' . $cve_valoracion_documento_opinion . ' nuevo';
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            $this->valoracion_documento_opinion_detalle($cve_valoracion_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_documento_opinion_guardar()
    {
        if ($this->session->userdata('logueado')) {

            $valoracion_documento_opinion = $this->input->post();
            if ($valoracion_documento_opinion) {

                // guardado
                $data = array(
                    'pertinencia' => $valoracion_documento_opinion['pertinencia'],
                    'prioridad' => $valoracion_documento_opinion['prioridad'],
                    'fundamentada' => $valoracion_documento_opinion['fundamentada'],
                    'observaciones' => $valoracion_documento_opinion['observaciones'],
                    'status' => 'valorada',
                );
                $cve_valoracion_documento_opinion = $this->valoraciones_documento_opinion_model->guardar($data, $valoracion_documento_opinion['cve_valoracion_documento_opinion']);
                
                $cve_documento_opinion = $valoracion_documento_opinion['cve_documento_opinion'];
                $num_valoraciones_documento_opinion = $this->valoraciones_documento_opinion_model->get_num_valoraciones_documento_opinion($cve_documento_opinion);
                $status_valoraciones_documento_opinion = $this->valoraciones_documento_opinion_model->get_status_valoraciones_documento_opinion($cve_documento_opinion);
                // probar si se completaron las valoraciones solamente si todas las valoraciones tienen status valorada
                $num_supervisores = $this->parametros_sistema_model->get_parametro_sistema_nom('num_supervisores');
                if ($num_valoraciones_documento_opinion == $num_supervisores and $status_valoraciones_documento_opinion == 'valorada') {

                    // probar si no hay observaciones
                    $observaciones_valoraciones_documento_opinion = $this->valoraciones_documento_opinion_model->get_observaciones_valoraciones_documento_opinion($cve_documento_opinion);
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
                if ($valoracion_documento_opinion['cve_valoracion_documento_opinion']) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
				$entidad = 'valoraciones_documento_opinion';
                $valor = $cve_valoracion_documento_opinion;
                $this->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('valoracion/documento_opinion_detalle/' . $valoracion_documento_opinion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function valoracion_documento_opinion_eliminar($cve_valoracion_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            // checar: al parecer no se usa
            $valoracion_documento_opinion = $this->valoraciones_documento_opinion_model->get_valoracion_documento_opinion($cve_valoracion_documento_opinion);

            // checar: ver si se puede mover después de la eliminación
            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'valoraciones_documento_opinion';
            $valor = "valoracion_documento_opinion ". $cve_valoracion_documento_opinion;
            $this->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->valoraciones_documento_opinion_model->eliminar($cve_valoracion_documento_opinion);

            redirect('valoracion/documento_opinion_detalle/' . $valoracion_documento_opinion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

}
