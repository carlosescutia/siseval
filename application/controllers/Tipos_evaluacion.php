<?php
class Tipos_evaluacion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('tipos_evaluacion_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'tipo_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/tipos_evaluacion/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_tipo_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'tipo_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['tipo_evaluacion'] = $this->tipos_evaluacion_model->get_tipo_evaluacion($id_tipo_evaluacion);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/tipos_evaluacion/detalle', $data);
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
                'tipo_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/tipos_evaluacion/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_tipo_evaluacion=null)
    {
        if ($this->session->userdata('logueado')) {

            $tipo_evaluacion = $this->input->post();
            if ($tipo_evaluacion) {

                if ($id_tipo_evaluacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_tipo_evaluacion' => $tipo_evaluacion['nom_tipo_evaluacion'],
                    'orden' => $tipo_evaluacion['orden'],
                );
                $id_tipo_evaluacion = $this->tipos_evaluacion_model->guardar($data, $id_tipo_evaluacion);

                // registro en bitacora
                $entidad = 'tipos_evaluacion';
                $valor = $id_tipo_evaluacion . " " . $tipo_evaluacion['nom_tipo_evaluacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('tipos_evaluacion');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_tipo_evaluacion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $tipo_evaluacion = $this->tipos_evaluacion_model->get_tipo_evaluacion($id_tipo_evaluacion);
            $accion = 'eliminó';
            $entidad = 'tipos_evaluacion';
            $valor = $id_tipo_evaluacion . " " . $tipo_evaluacion['nom_tipo_evaluacion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->tipos_evaluacion_model->eliminar($id_tipo_evaluacion);

            redirect('tipos_evaluacion');

        } else {
            redirect('inicio/login');
        }
    }

}
