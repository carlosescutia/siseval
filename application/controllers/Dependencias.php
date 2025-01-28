<?php
class Dependencias extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('dependencias_model');
        $this->load->model('dependencias_periodos_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'dependencia.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['dependencias'] = $this->dependencias_model->get_dependencias();

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/dependencias/lista', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_dependencia)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'dependencia.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['dependencias'] = $this->dependencias_model->get_dependencia($cve_dependencia);
                $data['dependencia_periodo'] = $this->dependencias_periodos_model->get_dependencia_periodo_dependencia($cve_dependencia);

                $this->load->view('templates/header', $data);
                $this->load->view('templates/dlg_borrar');
                $this->load->view('catalogos/dependencias/detalle', $data);
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
                'dependencia.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/dependencias/nuevo', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_dependencia=null)
    {
        if ($this->session->userdata('logueado')) {

            $dependencias = $this->input->post();
            if ($dependencias) {

                if ($cve_dependencia) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'nom_completo_dependencia' => $dependencias['nom_completo_dependencia'],
                    'nom_dependencia' => $dependencias['nom_dependencia']
                );
                $cve_dependencia = $this->dependencias_model->guardar($data, $cve_dependencia);

                // registro en bitacora
                $entidad = 'dependencias';
                $valor = $cve_dependencia . " " . $dependencias['nom_dependencia'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('dependencias');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_dependencia)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $dependencia = $this->dependencias_model->get_dependencia($cve_dependencia);
            $accion = 'eliminó';
            $entidad = 'dependencias';
            $valor = $cve_dependencia . " " . $dependencia['nom_dependencia'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->dependencias_model->eliminar($cve_dependencia);

            redirect('dependencias');

        } else {
            redirect('inicio/login');
        }
    }

    public function desactivar_evaluaciones()
    {
        if ($this->session->userdata('logueado')) {

            $dependencias = $this->input->post();
            if ($dependencias) {

                // guardado
                $data = array(
                    'carga_evaluaciones' => 0
                );
                $cve_dependencia = $dependencias['cve_dependencia'];
                $this->dependencias_model->guardar($data, $cve_dependencia);

                // registro en bitacora
                $separador = ' -> ';
                $entidad = 'dependencias';
                $valor = 'carga_evaluaciones' . $separador . '0' ;
                $accion = 'modificó';
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

    public function activar_evaluaciones()
    {
        if ($this->session->userdata('logueado')) {

            $dependencias = $this->input->post();
            if ($dependencias) {

                // guardado
                $data = array(
                    'carga_evaluaciones' => 1
                );
                $cve_dependencia = $dependencias['cve_dependencia'];
                $this->dependencias_model->guardar($data, $cve_dependencia);

                // registro en bitacora
                $separador = ' -> ';
                $entidad = 'dependencias';
                $valor = 'carga_evaluaciones' . $separador . '1' ;
                $accion = 'modificó';
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }
            redirect('proyectos');

        } else {
            redirect('inicio/login');
        }
    }

}
