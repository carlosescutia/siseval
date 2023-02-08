<?php
class Evaluaciones_actuales extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('bitacora_model');

        $this->load->model('evaluaciones_actuales_model');
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $evaluacion_actual = $this->input->post();
            if ($evaluacion_actual) {

                $id_evaluacion_actual = $evaluacion_actual['id_evaluacion_actual'];
                if ($id_evaluacion_actual) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'cve_proyecto' => $evaluacion_actual['cve_proyecto'],
                    'id_tipo_evaluacion' => empty($evaluacion_actual['id_tipo_evaluacion']) ? null : $evaluacion_actual['id_tipo_evaluacion'],
                    'otro_tipo_evaluacion' => $evaluacion_actual['otro_tipo_evaluacion'],
                    'id_justificacion_evaluacion' => empty($evaluacion_actual['id_justificacion_evaluacion']) ? null : $evaluacion_actual['id_justificacion_evaluacion'],
                    'otra_justificacion_evaluacion' => $evaluacion_actual['otra_justificacion_evaluacion'],
                    'anios_ejecucion' => empty($evaluacion_actual['anios_ejecucion']) ? null : $evaluacion_actual['anios_ejecucion'],
                    'meses_duracion' => empty($evaluacion_actual['meses_duracion']) ? null : $evaluacion_actual['meses_duracion'],
                    'objetivo' => $evaluacion_actual['objetivo'],
                    'recursos_propios' => $evaluacion_actual['recursos_propios'],
                    'monto' => empty($evaluacion_actual['monto']) ? null : $evaluacion_actual['monto'],
                    'observaciones' => $evaluacion_actual['observaciones']
                );
                $id_evaluacion_actual = $this->evaluaciones_actuales_model->guardar($data, $id_evaluacion_actual);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'evaluaciones_actuales';
                $valor = $id_evaluacion_actual . " " . $evaluacion_actual['cve_proyecto'];
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

            redirect('proyectos/detalle/'.$evaluacion_actual['cve_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_evaluacion_actual)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $evaluacion_actual = $this->evaluaciones_actuales_model->get_evaluacion_actual($id_evaluacion_actual);

            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'evaluaciones_actuales';
            $valor = $id_evaluacion_actual . " " . $evaluacion_actual['cve_proyecto'];
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
            $this->evaluaciones_actuales_model->eliminar($id_evaluacion_actual);

            redirect('proyectos/detalle/'.$evaluacion_actual['cve_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

}

