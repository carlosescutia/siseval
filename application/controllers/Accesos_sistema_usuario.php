<?php
class Accesos_sistema_usuario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');

        $this->load->model('accesos_sistema_usuario_model');
    }

    public function get_userdata()
    {
        $cve_usuario = $this->session->userdata('cve_usuario');
        $cve_rol = $this->session->userdata('cve_rol');
        $data['cve_usuario'] = $this->session->userdata('cve_usuario');
        $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
        $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
        $data['cve_rol'] = $cve_rol;
        $data['nom_usuario'] = $this->session->userdata('nom_usuario');
        $data['error'] = $this->session->flashdata('error');
        $data['permisos_usuario'] = explode(',', $this->accesos_sistema_model->get_permisos_usuario($cve_usuario));

        $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

        return $data;
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
				$separador = ' -> ';
				$usuario = $this->session->userdata('usuario');
				$nom_usuario = $this->session->userdata('nom_usuario');
				$nom_dependencia = $this->session->userdata('nom_dependencia');
				$entidad = 'accesos_sistema_usuario';
                $valor = $cve_acceso . " " . $acceso_sistema_usuario['cod_opcion'];
				$data = array(
					'fecha' => date("Y-m-d"),
					'hora' => date("H:i"),
					'origen' => $_SERVER['REMOTE_ADDR'],
					'usuario' => $usuario,
					'nom_usuario' => $nom_usuario,
					'nom_dependencia' => $nom_dependencia,
					'accion' => $accion,
					'entidad' => $entidad,
					'valor' => $valor
				);
				$this->bitacora_model->guardar($data);

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
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'accesos_sistema_usuario';
            $valor = $cve_acceso . " " . $acceso_sistema_usuario['cod_opcion'];
            $data = array(
                'fecha' => date("Y-m-d"),
                'hora' => date("H:i"),
                'origen' => $_SERVER['REMOTE_ADDR'],
                'usuario' => $usuario,
                'nom_usuario' => $nom_usuario,
                'nom_dependencia' => $nom_dependencia,
                'accion' => $accion,
                'entidad' => $entidad,
                'valor' => $valor
            );
            $this->bitacora_model->guardar($data);

            // eliminado
            $this->accesos_sistema_usuario_model->eliminar($cve_acceso);

            redirect('usuarios/detalle/'.$cve_usuario);

        } else {
            redirect('inicio/login');
        }
    }

}
