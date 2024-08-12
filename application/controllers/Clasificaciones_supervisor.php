<?php
class Clasificaciones_supervisor extends CI_Controller {
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

        $this->load->model('clasificaciones_supervisor_model');
        
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
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/clasificaciones_supervisor/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_clasificacion_supervisor)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $permisos_requeridos = array(
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['clasificacion_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificacion_supervisor($id_clasificacion_supervisor);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/clasificaciones_supervisor/detalle', $data);
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
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/clasificaciones_supervisor/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_clasificacion_supervisor=null)
    {
        if ($this->session->userdata('logueado')) {

            $clasificacion_supervisor = $this->input->post();
            if ($clasificacion_supervisor) {

                if ($id_clasificacion_supervisor) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_clasificacion_supervisor' => $clasificacion_supervisor['nom_clasificacion_supervisor'],
                    'orden' => $clasificacion_supervisor['orden'],
                );
                $id_clasificacion_supervisor = $this->clasificaciones_supervisor_model->guardar($data, $id_clasificacion_supervisor);
                
                // registro en bitacora
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'clasificaciones_supervisor';
                $valor = $id_clasificacion_supervisor . " " . $clasificacion_supervisor['nom_clasificacion_supervisor'];
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

            redirect('clasificaciones_supervisor');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_clasificacion_supervisor)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $clasificacion_supervisor = $this->clasificaciones_supervisor_model->get_clasificacion_supervisor($id_clasificacion_supervisor);
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'clasificaciones_supervisor';
            $valor = $id_clasificacion_supervisor . " " . $clasificacion_supervisor['nom_clasificacion_supervisor'];
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
            $this->clasificaciones_supervisor_model->eliminar($id_clasificacion_supervisor);

            redirect('clasificaciones_supervisor');

        } else {
            redirect('inicio/login');
        }
    }

}
