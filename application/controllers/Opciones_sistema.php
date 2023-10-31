<?php
class Opciones_sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('opciones_sistema_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('bitacora_model');
        $this->load->model('parametros_sistema_model');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            $data['etapa_siseval'] = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');

            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('catalogos/opciones_sistema/lista', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function detalle($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            $data['etapa_siseval'] = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');
            
            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $data['opcion_sistema'] = $this->opciones_sistema_model->get_opcion($cve_opcion);

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/opciones_sistema/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo()
    {
        if ($this->session->userdata('logueado')) {
            $cve_rol = $this->session->userdata('cve_rol');
            $data['cve_usuario'] = $this->session->userdata('cve_usuario');
            $data['cve_dependencia'] = $this->session->userdata('cve_dependencia');
            $data['nom_dependencia'] = $this->session->userdata('nom_dependencia');
            $data['cve_rol'] = $cve_rol;
            $data['nom_usuario'] = $this->session->userdata('nom_usuario');
            $data['error'] = $this->session->flashdata('error');
            $data['accesos_sistema_rol'] = explode(',', $this->accesos_sistema_model->get_accesos_sistema_rol($cve_rol)['accesos']);
            $data['opciones_sistema'] = $this->opciones_sistema_model->get_opciones_sistema();
            $data['etapa_siseval'] = $this->parametros_sistema_model->get_parametro_sistema_nom('etapa_siseval');

            if ($cve_rol != 'adm') {
                redirect('inicio');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('catalogos/opciones_sistema/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar($cve_opcion=null)
    {
        if ($this->session->userdata('logueado')) {

            $opciones_sistema = $this->input->post();
            if ($opciones_sistema) {
                
                if ($cve_opcion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }
                // guardado
                $data = array(
                    'cod_opcion' => $opciones_sistema['cod_opcion'],
                    'nom_opcion' => $opciones_sistema['nom_opcion'],
                    'url' => $opciones_sistema['url'],
                    'es_menu' => $opciones_sistema['es_menu'],
                    'etapa' => $opciones_sistema['etapa']
                );
                $cve_opcion = $this->opciones_sistema_model->guardar($data, $cve_opcion);

                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'opciones_sistema';
                $valor = $cve_opcion ." ". $opciones_sistema['cod_opcion'] . " " . $opciones_sistema['nom_opcion'];
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
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($cve_opcion)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $opcion = $this->opciones_sistema_model->get_opcion($cve_opcion);
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $accion = 'eliminó';
            $entidad = 'opciones_sistema';
            $valor = $cve_opcion ." ". $opcion['cod_opcion'] . " " . $opcion['nom_opcion'];
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
            $this->opciones_sistema_model->eliminar($cve_opcion);
            redirect('opciones_sistema');

        } else {
            redirect('inicio/login');
        }
    }

}
