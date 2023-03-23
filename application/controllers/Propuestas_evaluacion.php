<?php
class Propuestas_evaluacion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');

        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('calificaciones_propuesta_model');
        $this->load->model('clasificaciones_supervisor_model');
    }

    public function detalle($id_propuesta_evaluacion)
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

            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $cve_dependencia, $cve_rol);
            $data['calificaciones_propuesta'] = $this->calificaciones_propuesta_model->get_calificaciones_propuesta_propuesta_evaluacion($id_propuesta_evaluacion, $cve_dependencia, $cve_rol);
            $data['calificacion_final_propuesta_evaluacion'] = $this->calificaciones_propuesta_model->get_calificacion_final_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['num_calificaciones_propuesta_dependencia'] = $this->calificaciones_propuesta_model->get_num_calificaciones_propuesta_dependencia($id_propuesta_evaluacion, $cve_dependencia);
            $data['id_propuesta_evaluacion'] = $id_propuesta_evaluacion;
            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('propuestas_evaluacion/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo($cve_proyecto)
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

            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['cve_proyecto'] = $cve_proyecto;

            $this->load->view('templates/header', $data);
            $this->load->view('propuestas_evaluacion/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->input->post();
            if ($propuesta_evaluacion) {

                $id_propuesta_evaluacion = $propuesta_evaluacion['id_propuesta_evaluacion'];
                if ($id_propuesta_evaluacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'cve_proyecto' => $propuesta_evaluacion['cve_proyecto'],
                    'cve_dependencia' => $propuesta_evaluacion['cve_dependencia'],
                    'id_tipo_evaluacion' => empty($propuesta_evaluacion['id_tipo_evaluacion']) ? null : $propuesta_evaluacion['id_tipo_evaluacion'],
                    'otro_tipo_evaluacion' => $propuesta_evaluacion['otro_tipo_evaluacion'],
                    'id_justificacion_evaluacion' => empty($propuesta_evaluacion['id_justificacion_evaluacion']) ? null : $propuesta_evaluacion['id_justificacion_evaluacion'],
                    'otra_justificacion_evaluacion' => $propuesta_evaluacion['otra_justificacion_evaluacion'],
                    'objetivo' => $propuesta_evaluacion['objetivo'],
                    'recursos_propios' => $propuesta_evaluacion['recursos_propios'],
                    'monto' => empty($propuesta_evaluacion['monto']) ? null : $propuesta_evaluacion['monto'],
                    'observaciones' => $propuesta_evaluacion['observaciones'],
                    'recomendaciones_previas' => empty($propuesta_evaluacion['recomendaciones_previas']) ? 0 : $propuesta_evaluacion['recomendaciones_previas'],
                    'justificacion_no_atencion' => $propuesta_evaluacion['justificacion_no_atencion'],
                    'info_diagnostico' => empty($propuesta_evaluacion['info_diagnostico']) ? null : $propuesta_evaluacion['info_diagnostico'],
                    'info_mir' => empty($propuesta_evaluacion['info_mir']) ? null : $propuesta_evaluacion['info_mir'],
                    'info_reglasop' => empty($propuesta_evaluacion['info_reglasop']) ? null : $propuesta_evaluacion['info_reglasop'],
                    'info_regsadm' => empty($propuesta_evaluacion['info_regsadm']) ? null : $propuesta_evaluacion['info_regsadm'],
                    'info_fuentes_of' => empty($propuesta_evaluacion['info_fuentes_of']) ? null : $propuesta_evaluacion['info_fuentes_of'],
                    'info_progpresup' => empty($propuesta_evaluacion['info_progpresup']) ? null : $propuesta_evaluacion['info_progpresup'],
                    'info_padronben' => empty($propuesta_evaluacion['info_padronben']) ? null : $propuesta_evaluacion['info_padronben'],
                    'info_lineamientos' => empty($propuesta_evaluacion['info_lineamientos']) ? null : $propuesta_evaluacion['info_lineamientos'],
                    'info_guiasop' => empty($propuesta_evaluacion['info_guiasop']) ? null : $propuesta_evaluacion['info_guiasop'],
                    'info_normativa' => empty($propuesta_evaluacion['info_normativa']) ? null : $propuesta_evaluacion['info_normativa'],
                    'info_otro' => empty($propuesta_evaluacion['info_otro']) ? null : $propuesta_evaluacion['info_otro'],
                    'otra_info_disponible' => $propuesta_evaluacion['otra_info_disponible'],
                );
                $id_propuesta_evaluacion = $this->propuestas_evaluacion_model->guardar($data, $id_propuesta_evaluacion);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'propuestas_evaluacion';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
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

            redirect('proyectos/detalle/'.$propuesta_evaluacion['cve_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

    public function guardar_clasificacion()
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->input->post();
            if ($propuesta_evaluacion) {

                $id_propuesta_evaluacion = $propuesta_evaluacion['id_propuesta_evaluacion'];

                // guardado
                $data = array(
                    'clasificacion_supervisor' => $propuesta_evaluacion['clasificacion_supervisor']
                );
                $id_propuesta_evaluacion = $this->propuestas_evaluacion_model->guardar($data, $id_propuesta_evaluacion);
                
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'propuestas_evaluacion';
                $accion = 'modificó';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
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

            redirect('proyectos/detalle/'.$propuesta_evaluacion['cve_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion);
            $calificaciones = $this->calificaciones_propuesta_model->get_calificaciones_propuesta_propuesta_evaluacion($id_propuesta_evaluacion);
            if ($calificaciones) {
                $this->session->set_flashdata('err_propuestas_evaluacion', 'Esta propuesta ya está calificada, no se puede eliminar');
            } else {
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $accion = 'eliminó';
                $entidad = 'propuestas_evaluacion';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
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
                $this->propuestas_evaluacion_model->eliminar($id_propuesta_evaluacion);
            }
            redirect('proyectos/detalle/'.$propuesta_evaluacion['cve_proyecto']);
        } else {
            redirect('inicio/login');
        }
    }

}

