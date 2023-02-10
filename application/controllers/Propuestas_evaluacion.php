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

            $this->load->view('templates/header', $data);
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

