<?php
class Justificaciones_evaluacion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('justificaciones_evaluacion_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
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
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
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
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'justificacion_evaluacion.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
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
                $entidad = 'justificaciones_evaluacion';
                $valor = $id_justificacion_evaluacion . " " . $justificacion_evaluacion['nom_justificacion_evaluacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

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
            $accion = 'eliminó';
            $entidad = 'justificaciones_evaluacion';
            $valor = $id_justificacion_evaluacion . " " . $justificacion_evaluacion['nom_justificacion_evaluacion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->justificaciones_evaluacion_model->eliminar($id_justificacion_evaluacion);

            redirect('justificaciones_evaluacion');

        } else {
            redirect('inicio/login');
        }
    }

}
