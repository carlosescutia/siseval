<?php
class Calificaciones_propuesta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');

        $this->load->model('calificaciones_propuesta_model');
        $this->load->model('clasificaciones_supervisor_model');
        $this->load->model('probabilidades_inclusion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('semaforo_proyectos_model');
    }

    public function detalle($id_calificacion_propuesta)
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

            $data['calificacion_propuesta'] = $this->calificaciones_propuesta_model->get_calificacion_propuesta($id_calificacion_propuesta);
            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();
            $data['probabilidades_inclusion'] = $this->probabilidades_inclusion_model->get_probabilidades_inclusion();

            $id_propuesta_evaluacion = $data['calificacion_propuesta']['id_propuesta_evaluacion'];
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['semaforo_proyecto'] = $this->semaforo_proyectos_model->get_semaforo_proyecto($data['propuesta_evaluacion']['cve_proyecto']);
            $data['ods'] = $this->propuestas_evaluacion_model->get_ods_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['tot_info_disponible'] = $this->propuestas_evaluacion_model->get_tot_info_disponible_propuesta_evaluacion($id_propuesta_evaluacion);

            $this->load->view('templates/header', $data);
            $this->load->view('calificaciones_propuesta/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo($id_propuesta_evaluacion)
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
            $data['anio_propuestas'] = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_propuestas');

            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();
            $data['id_propuesta_evaluacion'] = $id_propuesta_evaluacion;
            $data['cve_dependencia'] = $cve_dependencia;

            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['semaforo_proyecto'] = $this->semaforo_proyectos_model->get_semaforo_proyecto($data['propuesta_evaluacion']['cve_proyecto']);
            $data['ods'] = $this->propuestas_evaluacion_model->get_ods_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['tot_info_disponible'] = $this->propuestas_evaluacion_model->get_tot_info_disponible_propuesta_evaluacion($id_propuesta_evaluacion);

            $this->load->view('templates/header', $data);
            $this->load->view('calificaciones_propuesta/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $calificacion_propuesta = $this->input->post();
            if ($calificacion_propuesta) {

                $id_calificacion_propuesta = $calificacion_propuesta['id_calificacion_propuesta'];
                if ($id_calificacion_propuesta) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'id_propuesta_evaluacion' => $calificacion_propuesta['id_propuesta_evaluacion'],
                    'cve_dependencia' => $calificacion_propuesta['cve_dependencia'],
                    'evaluacion_obligatoria' => $calificacion_propuesta['evaluacion_obligatoria'],
                    'agenda2030' => $calificacion_propuesta['agenda2030'],
                    'pertinencia_evaluacion' => $calificacion_propuesta['pertinencia_evaluacion'],
                    'ciclo_evaluativo' => $calificacion_propuesta['ciclo_evaluativo'],
                    'recomendaciones_previas' => $calificacion_propuesta['recomendaciones_previas'],
                    'justificacion_no_atencion' => $calificacion_propuesta['justificacion_no_atencion'],
                    'informacion_disponible' => $calificacion_propuesta['informacion_disponible'],
                    'clasificacion_supervisor' => $calificacion_propuesta['clasificacion_supervisor'],
                    'comentarios' => $calificacion_propuesta['comentarios'],
                    'criterio_institucional' => $calificacion_propuesta['criterio_institucional']
                );
                $id_calificacion_propuesta = $this->calificaciones_propuesta_model->guardar($data, $id_calificacion_propuesta);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'calificaciones_propuesta';
                $valor = $id_calificacion_propuesta . " " . $calificacion_propuesta['cve_dependencia'];
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

            redirect('propuestas_evaluacion/detalle/'.$calificacion_propuesta['id_propuesta_evaluacion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_calificacion_propuesta)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $calificacion_propuesta = $this->calificaciones_propuesta_model->get_calificacion_propuesta($id_calificacion_propuesta);

            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'calificaciones_propuesta';
            $valor = $id_calificacion_propuesta . " " . $calificacion_propuesta['cve_proyecto'];
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
            $this->calificaciones_propuesta_model->eliminar($id_calificacion_propuesta);

            redirect('propuestas_evaluacion/detalle/'.$calificacion_propuesta['id_propuesta_evaluacion']);

        } else {
            redirect('inicio/login');
        }
    }

}
