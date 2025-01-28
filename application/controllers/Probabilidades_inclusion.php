<?php
class Probabilidades_inclusion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('probabilidades_inclusion_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'probabilidad_inclusion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['probabilidades_inclusion'] = $this->probabilidades_inclusion_model->get_probabilidades_inclusion();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/probabilidades_inclusion/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_probabilidad_inclusion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'probabilidad_inclusion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['probabilidad_inclusion'] = $this->probabilidades_inclusion_model->get_probabilidad_inclusion($id_probabilidad_inclusion);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/probabilidades_inclusion/detalle', $data);
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
                'probabilidad_inclusion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/probabilidades_inclusion/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_probabilidad_inclusion=null)
    {
        if ($this->session->userdata('logueado')) {

            $probabilidad_inclusion = $this->input->post();
            if ($probabilidad_inclusion) {

                if ($id_probabilidad_inclusion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'min' => $probabilidad_inclusion['min'],
                    'max' => $probabilidad_inclusion['max'],
                    'nom_probabilidad_inclusion' => $probabilidad_inclusion['nom_probabilidad_inclusion'],
                    'orden' => $probabilidad_inclusion['orden'],
                );
                $id_probabilidad_inclusion = $this->probabilidades_inclusion_model->guardar($data, $id_probabilidad_inclusion);

                // registro en bitacora
                $entidad = 'probabilidades_inclusion';
                $valor = $id_probabilidad_inclusion . " " . $probabilidad_inclusion['nom_probabilidad_inclusion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('probabilidades_inclusion');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_probabilidad_inclusion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $probabilidad_inclusion = $this->probabilidades_inclusion_model->get_probabilidad_inclusion($id_probabilidad_inclusion);
            $accion = 'eliminó';
            $entidad = 'probabilidades_inclusion';
            $valor = $id_probabilidad_inclusion . " " . $probabilidad_inclusion['nom_probabilidad_inclusion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->probabilidades_inclusion_model->eliminar($id_probabilidad_inclusion);

            redirect('probabilidades_inclusion');

        } else {
            redirect('inicio/login');
        }
    }

}
