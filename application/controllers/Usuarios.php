<?php
class Usuarios extends CI_Controller {
    // globales
    var $etapa_actual;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usuarios_model');
        $this->load->model('roles_model');
        $this->load->model('dependencias_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');
        
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
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['usuarios'] = $this->usuarios_model->get_usuarios();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/usuarios/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_usuario)
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $permisos_requeridos = array(
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['usuarios'] = $this->usuarios_model->get_usuario($cve_usuario);
                $data['roles'] = $this->roles_model->get_roles();
                $data['dependencias'] = $this->dependencias_model->get_dependencias();

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/usuarios/detalle', $data);
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
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['permisos_usuario'])) {
                $data['roles'] = $this->roles_model->get_roles();
                $data['dependencias'] = $this->dependencias_model->get_dependencias();

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/usuarios/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_usuario=null)
    {
        if ($this->session->userdata('logueado')) {

            $usuarios = $this->input->post();
            if ($usuarios) {
                
                if ($cve_usuario) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'cve_dependencia' => $usuarios['cve_dependencia'],
                    'cve_rol' => $usuarios['cve_rol'],
                    'nom_usuario' => $usuarios['nom_usuario'],
                    'usuario' => $usuarios['usuario'],
                    'password' => $usuarios['password'],
                    'activo' => empty($usuarios['activo']) ? '0' : $usuarios['activo']
                );
                $cve_usuario = $this->usuarios_model->guardar($data, $cve_usuario);

                // registro en bitacora
                $dependencia = $this->dependencias_model->get_dependencia($usuarios['cve_dependencia']);
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'usuarios';
                $valor = $cve_usuario ." ". $usuarios['nom_usuario'] . $separador . $dependencia['nom_dependencia'];
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
            redirect('usuarios');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_usuario)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $datos_usuario = $this->usuarios_model->get_usuario($cve_usuario);
			$separador = ' -> ';
			$usuario = $this->session->userdata('usuario');
			$nom_usuario = $this->session->userdata('nom_usuario');
			$nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
			$entidad = 'usuarios';
			$valor = $cve_usuario ." ". $datos_usuario['nom_usuario'] . $separador . $datos_usuario['nom_dependencia'];
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
			$this->usuarios_model->eliminar($cve_usuario);

			redirect('usuarios');
		} else {
			redirect('inicio/login');
		}
	}
}
