<?php
class Valoracion extends CI_Controller {

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
            $data['etapa_actual'] = 3 ;
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
            $data['etapa_actual'] = 1 ;
            $data['err_propuestas_evaluacion'] = $this->session->flashdata('err_propuestas_evaluacion');

            $data['documento_opinion'] = $this->documentos_opinion_model->get_documento_opinion($cve_documento_opinion);
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion_doc_op($cve_documento_opinion);
            $data['recomendaciones'] = $this->recomendaciones_model->get_recomendaciones_doc_op($cve_documento_opinion);
            $data['status_documentos_opinion'] = $this->status_documentos_opinion_model->get_status_documentos_opinion();

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

            $accion = 'agregó';

            // guardado
            $data = array(
                'id_propuesta_evaluacion' => $id_propuesta_evaluacion,
                'fecha_elaboracion' => date('Y-m-d'),
                'status' => 2,
            );
            $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, null);

            // registro en bitacora
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $entidad = 'documentos_opinion';
            $valor = 'doc_op ' . $cve_documento_opinion . ' nuevo';
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

            $this->documento_opinion_detalle($cve_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function documento_opinion_revision($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            $accion = 'modificó';

            // guardado
            $data = array(
                'fecha_elaboracion' => date('Y-m-d'),
                'status' => 3,
            );
            $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, $cve_documento_opinion);

            // registro en bitacora
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $entidad = 'documentos_opinion';
            $valor = 'doc_op ' . $cve_documento_opinion . ' revision';
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

                if ($cve_documento_opinion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'fecha_elaboracion' => $documento_opinion['fecha_elaboracion'],
                    'instancia_evaluadora' => $documento_opinion['instancia_evaluadora'],
                    'elaborado_por' => $documento_opinion['elaborado_por'],
                    'antecedentes' => $documento_opinion['antecedentes'],
                );
                $cve_documento_opinion = $this->documentos_opinion_model->guardar($data, $cve_documento_opinion);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'documentos_opinion';
                $valor = $cve_documento_opinion;
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

            redirect('valoracion/documento_opinion_detalle/' . $cve_documento_opinion);

        } else {
            redirect('inicio/login');
        }
    }

    public function recomendaciones_nuevo($cve_documento_opinion)
    {
        if ($this->session->userdata('logueado')) {

            $accion = 'agregó';

            // guardado
            $data = array(
                'cve_documento_opinion' => $cve_documento_opinion,
            );
            $cve_recomendacion = $this->recomendaciones_model->guardar($data, null);

            // registro en bitacora
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $entidad = 'recomendaciones';
            $valor = $cve_recomendacion;
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
                $accion = 'modificó';

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
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'recomendaciones';
                $valor = $cve_recomendacion;
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

            redirect('valoracion/documento_opinion_detalle/' . $recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function recomendaciones_eliminar($cve_recomendacion)
    {
        if ($this->session->userdata('logueado')) {

            $recomendacion = $this->recomendaciones_model->get_recomendacion($cve_recomendacion);

            // registro en bitacora
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'recomendaciones';
            $valor = "Recomendacion ". $cve_recomendacion;
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
            $this->recomendaciones_model->eliminar($cve_recomendacion);

            redirect('valoracion/documento_opinion_detalle/' . $recomendacion['cve_documento_opinion']);

        } else {
            redirect('inicio/login');
        }
    }

}
