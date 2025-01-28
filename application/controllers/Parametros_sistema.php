<?php
class Parametros_sistema extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('parametros_sistema_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['parametros_sistema'] = $this->parametros_sistema_model->get_parametros_sistema();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/parametros_sistema/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_parametro_sistema)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['parametros_sistema'] = $this->parametros_sistema_model->get_parametro_sistema_cve($cve_parametro_sistema);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/parametros_sistema/detalle', $data);
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
                'parametro_sistema.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/parametros_sistema/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_parametro_sistema=null)
    {
        if ($this->session->userdata('logueado')) {

            $parametros_sistema = $this->input->post();
            if ($parametros_sistema) {

                if ($cve_parametro_sistema) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_parametro_sistema' => $parametros_sistema['nom_parametro_sistema'],
                    'valor_parametro_sistema' => $parametros_sistema['valor_parametro_sistema']
                );
                $cve_parametro_sistema = $this->parametros_sistema_model->guardar($data, $cve_parametro_sistema);

                // registro en bitacora
                $entidad = 'parametros_sistema';
                $valor = $cve_parametro_sistema . " " . $parametros_sistema['nom_parametro_sistema'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('parametros_sistema');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_parametro_sistema)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $parametro_sistema = $this->parametros_sistema_model->get_parametro_sistema_cve($cve_parametro_sistema);
            $accion = 'eliminó';
            $entidad = 'parametros_sistema';
            $valor = $cve_parametro_sistema . " " . $parametro_sistema['nom_parametro_sistema'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->parametros_sistema_model->eliminar($cve_parametro_sistema);

            redirect('parametros_sistema');

        } else {
            redirect('inicio/login');
        }
    }

}
