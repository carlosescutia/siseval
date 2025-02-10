<?php
class Accesos_sistema_usuario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('accesos_sistema_usuario_model');
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $acceso_sistema_usuario = $this->input->post();
            if ($acceso_sistema_usuario) {

                if ($acceso_sistema_usuario['cve_acceso']) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                $cve_usuario = $acceso_sistema_usuario['cve_usuario'];
                // guardado
                $data = array(
                    'cve_usuario' => $acceso_sistema_usuario['cve_usuario'],
                    'cod_opcion' => $acceso_sistema_usuario['cod_opcion'],
                );
                $cve_acceso = $this->accesos_sistema_usuario_model->guardar($data, $acceso_sistema_usuario['cve_acceso']);

                // registro en bitacora
                $entidad = 'accesos_sistema_usuario';
                $valor = $cve_acceso . " " . $acceso_sistema_usuario['cod_opcion'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('usuarios/detalle/'.$cve_usuario);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_acceso)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $acceso_sistema_usuario = $this->accesos_sistema_usuario_model->get_acceso_sistema_usuario($cve_acceso);
            $cve_usuario = $acceso_sistema_usuario['cve_usuario'];
            $accion = 'eliminó';
            $entidad = 'accesos_sistema_usuario';
            $valor = $cve_acceso . " " . $acceso_sistema_usuario['cod_opcion'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->accesos_sistema_usuario_model->eliminar($cve_acceso);

            redirect('usuarios/detalle/'.$cve_usuario);

        } else {
            redirect('inicio/login');
        }
    }

}
