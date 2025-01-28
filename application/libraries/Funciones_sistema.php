<?php
class Funciones_sistema extends CI_Controller {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->model('parametros_sistema_model');
        $this->CI->load->model('accesos_sistema_model');
        $this->CI->load->model('bitacora_model');
    }

    public function recargar_permisos($etapa_modulo, $nom_etapa_modulo)
    {
        // actualizar anio_activo, etapa_activa, permisos_usuario y periodos
        $data['userdata'] = $this->CI->session->userdata;

        $etapa_activa = $this->CI->parametros_sistema_model->get_parametro_sistema_nom('etapa_activa');

        $permisos_usuario = explode(',', $this->CI->accesos_sistema_model->get_permisos_usuario($data['userdata']['cve_usuario']));
        if ($etapa_activa == $etapa_modulo) { 
            array_push($permisos_usuario, $nom_etapa_modulo); 
        }

        $anio_activo = $this->CI->parametros_sistema_model->get_parametro_sistema_nom('anio_activo');
        $anio_sesion = $data['userdata']['anio_sesion'];
        if ($anio_activo == $anio_sesion) {
            array_push($permisos_usuario, 'anio_activo'); 
        }

        $this->CI->session->set_userdata('permisos_usuario', $permisos_usuario);

        $periodos = array(array('periodo' => $data['userdata']['anio_sesion']));
        $this->CI->session->set_userdata('periodos', $periodos);

    }

    public function registro_bitacora($accion, $entidad, $valor)
    {

        // registro en bitacora
        $usuario = $this->CI->session->userdata('usuario');
        $nom_usuario = $this->CI->session->userdata('nom_usuario');
        $nom_dependencia = $this->CI->session->userdata('nom_dependencia');
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
        $this->CI->bitacora_model->guardar($data);
    }
}
