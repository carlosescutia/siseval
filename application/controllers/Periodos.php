<?php
class Periodos extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('periodos_model');
        $this->load->model('criterios_calificacion_model');
        $this->load->model('criterios_calificacion_periodo_model');

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
                $data['periodos'] = $this->periodos_model->get_periodos();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/periodos/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_periodo)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'calendario.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $periodo = $data['userdata']['anio_sesion'];
                $data['periodo'] = $this->periodos_model->get_periodo($id_periodo);
                $data['criterios_calificacion'] = $this->criterios_calificacion_model->get_criterios_calificacion();
                $data['criterios_calificacion_periodo'] = $this->criterios_calificacion_periodo_model->get_criterios_calificacion_periodo($data['periodo']['nom_periodo']);

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/periodos/detalle', $data);
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
                $this->load->view('catalogos/periodos/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_periodo=null)
    {
        if ($this->session->userdata('logueado')) {

            $periodo = $this->input->post();
            if ($periodo) {

                if ($id_periodo) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_periodo' => $periodo['nom_periodo'],
                    'num_supervisores' => $periodo['num_supervisores'],
                );
                $id_periodo = $this->periodos_model->guardar($data, $id_periodo);

                // registro en bitacora
                $entidad = 'periodos';
                $valor = $id_periodo . " " . $periodo['nom_periodo'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('periodos');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_periodo)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'periodos';
            $valor = $id_periodo . " " . $periodo['nom_periodo'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->periodos_model->eliminar($id_periodo);

            redirect('periodos');

        } else {
            redirect('inicio/login');
        }
    }

}
