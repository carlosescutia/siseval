<?php
class Dependencias_periodos extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('dependencias_periodos_model');
        $this->load->model('dependencias_model');

        $this->etapa_modulo = 0;
        $this->nom_etapa_modulo = '';
    }

    public function detalle($id_dependencia_periodo)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $permisos_requeridos = array(
                'dependencia.can_edit',
            );
            if (has_permission_or($permisos_requeridos, $data['userdata']['permisos_usuario'])) {
                $data['dependencia_periodo'] = $this->dependencias_periodos_model->get_dependencia_periodo($id_dependencia_periodo);
                $data['dependencia'] = $this->dependencias_model->get_dependencia($data['dependencia_periodo']['cve_dependencia']);

                $this->load->view('templates/header', $data);
                $this->load->view('catalogos/dependencias_periodos/detalle', $data);
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

                $cve_dependencia = $this->input->post('cve_dependencia');
                if ($cve_dependencia) {
                    $data['dependencia'] = $this->dependencias_model->get_dependencia($cve_dependencia);

                    $this->load->view('templates/header', $data);
                    $this->load->view('catalogos/dependencias_periodos/nuevo', $data);
                    $this->load->view('templates/footer');
                }
            }
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($id_dependencia_periodo=null)
    {
        if ($this->session->userdata('logueado')) {

            $dependencia_periodo = $this->input->post();
            $cve_dependencia = $dependencia_periodo['cve_dependencia'];
            if ($dependencia_periodo) {

                if ($id_dependencia_periodo) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'cve_dependencia' => $dependencia_periodo['cve_dependencia'],
                    'periodo' => $dependencia_periodo['periodo'],
                    'nom_dependencia' => $dependencia_periodo['nom_dependencia'],
                    'nom_completo_dependencia' => $dependencia_periodo['nom_completo_dependencia'],
                );
                $id_dependencia_periodo = $this->dependencias_periodos_model->guardar($data, $id_dependencia_periodo);

                // registro en bitacora
                $entidad = 'dependencia_periodo';
                $valor = $dependencia_periodo['periodo'] . " " . $dependencia_periodo['nom_completo_dependencia'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect(base_url() . 'dependencias/detalle/' . $cve_dependencia);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_dependencia_periodo)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $dependencia_periodo = $this->dependencias_periodos_model->get_dependencia_periodo($id_dependencia_periodo);
            $cve_dependencia = $dependencia_periodo['cve_dependencia'];
            $accion = 'eliminó';
            $entidad = 'dependencias_periodos';
            $valor = $dependencia_periodo['periodo'] . " " . $dependencia_periodo['nom_completo_dependencia'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->dependencias_periodos_model->eliminar($id_dependencia_periodo);

            redirect(base_url() . 'dependencias/detalle/' . $cve_dependencia);

        } else {
            redirect('inicio/login');
        }
    }

}
