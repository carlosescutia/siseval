<?php
class Eventos extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('eventos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {

                $anio_sesion = $this->session->userdata('anio_sesion');
                $data['eventos'] = $this->eventos_model->get_eventos($anio_sesion);

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/eventos/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_evento)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['evento'] = $this->eventos_model->get_evento($id_evento);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/eventos/detalle', $data);
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
                $this->load->view('catalogos/eventos/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_evento=null)
    {
        if ($this->session->userdata('logueado')) {

            $evento = $this->input->post();
            if ($evento) {

                if ($id_evento) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'fecha_evento' => $evento['fecha_evento'],
                    'desc_evento' => $evento['desc_evento'],
                );
                $id_evento = $this->eventos_model->guardar($data, $id_evento);

                // registro en bitacora
                $entidad = 'eventos';
                $valor = $id_evento . " " . $evento['desc_evento'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('eventos');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_evento)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'eventos';
            $valor = $id_evento . " " . $evento['desc_evento'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->eventos_model->eliminar($id_evento);

            redirect('eventos');

        } else {
            redirect('inicio/login');
        }
    }

}
