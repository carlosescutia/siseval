<?php
class Usuarios extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct() {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('usuarios_model');
        $this->load->model('roles_model');
        $this->load->model('dependencias_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('accesos_sistema_usuario_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $anio_sesion = $this->session->userdata('anio_sesion');

            $permisos_requeridos = array(
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['usuarios'] = $this->usuarios_model->get_usuarios($anio_sesion);

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
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['usuarios'] = $this->usuarios_model->get_usuario($cve_usuario);
                $data['roles'] = $this->roles_model->get_roles();
                $data['dependencias'] = $this->dependencias_model->get_dependencias();
                $data['accesos_sistema_rol'] = $this->accesos_sistema_model->get_accesos_sistema_rol_usuario($cve_usuario);
                $data['accesos_sistema_usuario'] = $this->accesos_sistema_usuario_model->get_accesos_sistema_usuario($cve_usuario);
                $data['opciones_sistema_otorgables'] = $this->opciones_sistema_model->get_opciones_sistema_otorgables();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
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
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'usuario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
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
                $entidad = 'usuarios';
                $valor = $cve_usuario ." ". $usuarios['nom_usuario'] . $separador . $dependencia['nom_dependencia'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

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
            $accion = 'eliminó';
            $entidad = 'usuarios';
            $valor = $cve_usuario ." ". $datos_usuario['nom_usuario'] . $separador . $datos_usuario['nom_dependencia'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->usuarios_model->eliminar($cve_usuario);

            redirect('usuarios');
        } else {
            redirect('inicio/login');
        }
    }
}
