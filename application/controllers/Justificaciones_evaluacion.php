<?php
class Justificaciones_evaluacion extends CI_Controller {
    // globales
    var $etapa_actual;


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');

        $this->load->model('justificaciones_evaluacion_model');
        
        // globales
        $this->etapa_actual = 0;
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
            array_push($data['permisos_usuario'], 'es_etapa_actual'); 
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

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/justificaciones_evaluacion/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_justificacion_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['justificacion_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificacion_evaluacion($id_justificacion_evaluacion);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/justificaciones_evaluacion/detalle', $data);
                $this->load->view('templates/footer');
            }
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

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/justificaciones_evaluacion/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_justificacion_evaluacion=null)
    {
        if ($this->session->userdata('logueado')) {

            $justificacion_evaluacion = $this->input->post();
            if ($justificacion_evaluacion) {

                if ($id_justificacion_evaluacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_justificacion_evaluacion' => $justificacion_evaluacion['nom_justificacion_evaluacion']
                );
                $id_justificacion_evaluacion = $this->justificaciones_evaluacion_model->guardar($data, $id_justificacion_evaluacion);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'justificaciones_evaluacion';
                $valor = $id_justificacion_evaluacion . " " . $justificacion_evaluacion['nom_justificacion_evaluacion'];
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

            redirect('justificaciones_evaluacion');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_justificacion_evaluacion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $justificacion_evaluacion = $this->justificaciones_evaluacion_model->get_justificacion_evaluacion($id_justificacion_evaluacion);
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'justificaciones_evaluacion';
            $valor = $id_justificacion_evaluacion . " " . $justificacion_evaluacion['nom_justificacion_evaluacion'];
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
            $this->justificaciones_evaluacion_model->eliminar($id_justificacion_evaluacion);

            redirect('justificaciones_evaluacion');

        } else {
            redirect('inicio/login');
        }
    }

}
