<?php
class Proyectos extends CI_Controller {

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

            $filtros = $this->input->post();
            if ($filtros) {
                $cve_dependencia_filtro = $filtros['cve_dependencia_filtro'];
                $anexo_social = $filtros['anexo_social'];
                $evaluaciones_propuestas = $filtros['evaluaciones_propuestas'];
            } else {
                $cve_dependencia_filtro = $cve_dependencia;
                if ($cve_rol == 'sup') {
                    $cve_dependencia_filtro = '%';
                }
                $anexo_social = '0';
                $evaluaciones_propuestas = '0';
			}
            $data['cve_dependencia_filtro'] = $cve_dependencia_filtro;
            $data['anexo_social'] = $anexo_social;
            $data['evaluaciones_propuestas'] = $evaluaciones_propuestas;

            $data['proyectos'] = $this->proyectos_model->get_proyectos_dependencia($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            $data['dependencias'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia_filtro, $anexo_social, $evaluaciones_propuestas);
            if ($cve_rol == 'sup' or $cve_rol == 'adm') {
                $cve_dependencia = '%';
            }

            $data['dependencias_filtro'] = $this->dependencias_model->get_dependencias_proyectos($cve_dependencia, 0, 0);

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
            $cve_proyecto = $data['proyecto']['cve_proyecto'];
            $cve_anterior_proyecto = $data['proyecto']['cve_anterior_proyecto'];
            $data['programa'] = $this->programas_model->get_programa_proyecto($cve_proyecto, $cve_dependencia, $cve_rol);
            $data['evaluaciones'] = $this->evaluaciones_model->get_evaluaciones_proyecto($cve_anterior_proyecto, $cve_dependencia, $cve_rol);
            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['propuestas_evaluacion'] = $this->propuestas_evaluacion_model->get_propuestas_evaluacion_proyecto($cve_proyecto);
            $data['num_propuestas_evaluacion_proyecto_dependencia'] = $this->propuestas_evaluacion_model->get_num_propuestas_evaluacion_proyecto_dependencia($cve_proyecto, $cve_dependencia);
            $data['parametros_sistema'] = $this->parametros_sistema_model->get_parametros_sistema();
            $data['metas'] = $this->metas_ods_model->get_metas_proyecto($cve_proyecto);

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
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

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

                $parametros_sistema = $this->parametros_sistema_model->get_parametros_sistema();
                foreach ($parametros_sistema as $parametros_sistema_item) {
                    if ($parametros_sistema_item['nom_parametro_sistema'] == 'anio_propuestas') {
                        $periodo = $parametros_sistema_item['valor_parametro_sistema'];
                    }
                } 

                $cve_dependencia = $this->session->userdata('cve_dependencia');
                $reg_consecutivo = $this->proyectos_model->get_consecutivo_dependencia($cve_dependencia);
                $consecutivo = $reg_consecutivo['consecutivo'];
                $consecutivo++;
                $cve_proyecto_nuevo = 'PRN' . str_pad($consecutivo, 2, '0', STR_PAD_LEFT) ;

                // guardado
                $data = array(
                    'cve_proyecto' => $cve_proyecto_nuevo,
                    'nom_proyecto' => $proyecto['nom_proyecto'],
                    'periodo' => $periodo,
                    'presupuesto_aprobado' => $proyecto['presupuesto_aprobado'],
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

            // registro en bitacora
            $cve_rol = $this->session->userdata('cve_rol');
            $cve_dependencia = $this->session->userdata('cve_dependencia');
            $proyecto = $this->proyectos_model->get_proyecto($id_proyecto, $cve_dependencia, $cve_rol);
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

            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

}
