<?php
class Evaluadores extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('evaluadores_model');
        $this->load->model('proyectos_model');

        $this->etapa_modulo = 4;
        $this->nom_etapa_modulo = 'valoracion.etapa_activa';
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
                'evaluador.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['evaluadores'] = $this->evaluadores_model->get_evaluadores();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/evaluadores/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($id_evaluador)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'evaluador.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['evaluador'] = $this->evaluadores_model->get_evaluador($id_evaluador);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/evaluadores/detalle', $data);
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
                'evaluador.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/evaluadores/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_evaluador=null)
    {
        if ($this->session->userdata('logueado')) {

            $evaluador = $this->input->post();
            if ($evaluador) {

                if ($id_evaluador) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'id_evaluador' => $evaluador['id_evaluador'],
                    'nom_evaluador' => $evaluador['nom_evaluador'],
                    'observaciones' => $evaluador['observaciones'],
                );
                $id_evaluador = $this->evaluadores_model->guardar($data, $id_evaluador);

                // registro en bitacora
                $entidad = 'evaluadores';
                $valor = $id_evaluador . " " . $evaluador['nom_evaluador'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('evaluadores');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_evaluador)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $accion = 'eliminó';
            $entidad = 'evaluadores';
            $valor = $id_evaluador . " " . $evaluador['nom_evaluador'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->evaluadores_model->eliminar($id_evaluador);

            redirect('evaluadores');

        } else {
            redirect('inicio/login');
        }
    }

}
