<?php
class Opciones_sistema extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

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

            $permisos_requeridos = array(
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/opciones_sistema/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['opcion_sistema'] = $this->opciones_sistema_model->get_opcion($cve_opcion);
                $data['roles_acceso'] = $this->accesos_sistema_model->get_roles_acceso($cve_opcion);
                $data['usuarios_acceso'] = $this->accesos_sistema_usuario_model->get_usuarios_acceso($cve_opcion);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/opciones_sistema/detalle', $data);
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
                'opcion_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/opciones_sistema/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_opcion=null)
    {
        if ($this->session->userdata('logueado')) {

            $opciones_sistema = $this->input->post();
            if ($opciones_sistema) {

                if ($cve_opcion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'cod_opcion' => $opciones_sistema['cod_opcion'],
                    'nom_opcion' => $opciones_sistema['nom_opcion'],
                    'otorgable' => empty($opciones_sistema['otorgable']) ? null : $opciones_sistema['otorgable'] ,
                );
                $cve_opcion = $this->opciones_sistema_model->guardar($data, $cve_opcion);

                // registro en bitacora
                $entidad = 'opciones_sistema';
                $valor = $cve_opcion ." ". $opciones_sistema['cod_opcion'] . " " . $opciones_sistema['nom_opcion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opciones_sistema_model->get_opcion($cve_opcion);
            $accion = 'eliminó';
            $entidad = 'opciones_sistema';
            $valor = $cve_opcion ." ". $opcion['cod_opcion'] . " " . $opcion['nom_opcion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->opciones_sistema_model->eliminar($cve_opcion);
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

}
