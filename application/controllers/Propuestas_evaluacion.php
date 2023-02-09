<?php
class Propuestas_evaluacion extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('bitacora_model');

        $this->load->model('propuestas_evaluacion_model');
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
                    'id_tipo_evaluacion' => empty($propuesta_evaluacion['id_tipo_evaluacion']) ? null : $propuesta_evaluacion['id_tipo_evaluacion'],
                    'otro_tipo_evaluacion' => $propuesta_evaluacion['otro_tipo_evaluacion'],
                    'id_justificacion_evaluacion' => empty($propuesta_evaluacion['id_justificacion_evaluacion']) ? null : $propuesta_evaluacion['id_justificacion_evaluacion'],
                    'otra_justificacion_evaluacion' => $propuesta_evaluacion['otra_justificacion_evaluacion'],
                    'anios_ejecucion' => empty($propuesta_evaluacion['anios_ejecucion']) ? null : $propuesta_evaluacion['anios_ejecucion'],
                    'meses_duracion' => empty($propuesta_evaluacion['meses_duracion']) ? null : $propuesta_evaluacion['meses_duracion'],
                    'objetivo' => $propuesta_evaluacion['objetivo'],
                    'recursos_propios' => $propuesta_evaluacion['recursos_propios'],
                    'monto' => empty($propuesta_evaluacion['monto']) ? null : $propuesta_evaluacion['monto'],
                    'observaciones' => $propuesta_evaluacion['observaciones']
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

    public function eliminar($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $propuesta_evaluacion = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion);

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

            redirect('proyectos/detalle/'.$propuesta_evaluacion['cve_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

}

