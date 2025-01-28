<?php
class Clasificaciones_supervisor extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('proyectos_model');
        $this->load->model('clasificaciones_supervisor_model');

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
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/clasificaciones_supervisor/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_clasificacion_supervisor)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['clasificacion_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificacion_supervisor($id_clasificacion_supervisor);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/clasificaciones_supervisor/detalle', $data);
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
                'clasificacion_supervisor.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/clasificaciones_supervisor/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_clasificacion_supervisor=null)
    {
        if ($this->session->userdata('logueado')) {

            $clasificacion_supervisor = $this->input->post();
            if ($clasificacion_supervisor) {

                if ($id_clasificacion_supervisor) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_clasificacion_supervisor' => $clasificacion_supervisor['nom_clasificacion_supervisor'],
                    'orden' => $clasificacion_supervisor['orden'],
                );
                $id_clasificacion_supervisor = $this->clasificaciones_supervisor_model->guardar($data, $id_clasificacion_supervisor);

                // registro en bitacora
                $entidad = 'clasificaciones_supervisor';
                $valor = $id_clasificacion_supervisor . " " . $clasificacion_supervisor['nom_clasificacion_supervisor'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('clasificaciones_supervisor');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_clasificacion_supervisor)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $clasificacion_supervisor = $this->clasificaciones_supervisor_model->get_clasificacion_supervisor($id_clasificacion_supervisor);
            $accion = 'eliminó';
            $entidad = 'clasificaciones_supervisor';
            $valor = $id_clasificacion_supervisor . " " . $clasificacion_supervisor['nom_clasificacion_supervisor'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->clasificaciones_supervisor_model->eliminar($id_clasificacion_supervisor);

            redirect('clasificaciones_supervisor');

        } else {
            redirect('inicio/login');
        }
    }

}
