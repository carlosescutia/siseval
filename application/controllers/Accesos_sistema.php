<?php
class Accesos_sistema extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('roles_model');
        $this->load->model('proyectos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $periodos = $this->proyectos_model->get_anios_proyectos();
            $this->session->set_userdata('periodos', $periodos);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'acceso_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['accesos_sistema'] = $this->accesos_sistema_model->get_accesos_sistema();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/accesos_sistema/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'acceso_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['roles'] = $this->roles_model->get_roles();
                $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/accesos_sistema/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

    public function guardar($cve_acceso=null)
    {
        if ($this->session->userdata('logueado')) {

            $accesos_sistema = $this->input->post();
            if ($accesos_sistema) {

                if ($cve_acceso) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'cod_opcion' => $accesos_sistema['cod_opcion'],
                    'cve_rol' => $accesos_sistema['cve_rol']
                );
                $cve_acceso = $this->accesos_sistema_model->guardar($data, $cve_acceso);

                // registro en bitacora
                $opcion = $this->opciones_sistema_model->get_opcion_cod($accesos_sistema['cod_opcion']);
                $separador = ' -> ';
                $entidad = 'accesos_sistema';
                $valor = $opcion['cod_opcion'] . " " . $opcion['nom_opcion'] . $separador . $rol['nom_rol'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect('accesos_sistema');

        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

    public function eliminar($cve_acceso)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $acceso = $this->accesos_sistema_model->get_acceso_sistema($cve_acceso);
            $opcion = $this->opciones_sistema_model->get_opcion_cod($acceso['cod_opcion']);
            $separador = ' -> ';
            $accion = 'eliminó';
            $entidad = 'accesos_sistema';
            $valor = $opcion['cod_opcion'] . " " . $opcion['nom_opcion'] . $separador . $rol['nom_rol'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->accesos_sistema_model->eliminar($cve_acceso);

            redirect('accesos_sistema');
        } else {
            redirect('inicio/iniciar_sesion');
        }
    }

}
