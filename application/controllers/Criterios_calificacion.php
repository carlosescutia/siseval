<?php
class Criterios_calificacion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('criterios_calificacion_model');
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
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['criterios_calificacion'] = $this->criterios_calificacion_model->get_criterios_calificacion();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/criterios_calificacion/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_criterio_calificacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $criterio_calificacion = $data['userdata']['anio_sesion'];
                $data['criterio_calificacion'] = $this->criterios_calificacion_model->get_criterio_calificacion($id_criterio_calificacion);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/criterios_calificacion/detalle', $data);
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
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/criterios_calificacion/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_criterio_calificacion=null)
    {
        if ($this->session->userdata('logueado')) {

            $criterio_calificacion = $this->input->post();
            if ($criterio_calificacion) {

                if ($id_criterio_calificacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_criterio' => $criterio_calificacion['nom_criterio'],
                );
                $id_criterio_calificacion = $this->criterios_calificacion_model->guardar($data, $id_criterio_calificacion);

                // registro en bitacora
                $entidad = 'criterios_calificacion';
                $valor = $id_criterio_calificacion . " " . $criterio_calificacion['nom_criterio_calificacion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('criterios_calificacion');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_criterio_calificacion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'criterios_calificacion';
            $valor = $id_criterio_calificacion . " " . $criterio_calificacion['nom_criterio_calificacion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->criterios_calificacion_model->eliminar($id_criterio_calificacion);

            redirect('criterios_calificacion');

        } else {
            redirect('inicio/login');
        }
    }

}
