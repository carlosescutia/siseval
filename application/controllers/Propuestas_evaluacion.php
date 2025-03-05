<?php
class Propuestas_evaluacion extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('tipos_evaluacion_model');
        $this->load->model('justificaciones_evaluacion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('calificaciones_propuesta_model');
        $this->load->model('clasificaciones_supervisor_model');

        // globales
        $this->etapa_modulo = 1;
        $this->nom_etapa_modulo = 'planificacion.etapa_activa';
    }

    public function detalle($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];
            $periodo = $data['userdata']['anio_sesion'];

            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $periodo);
            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['calificaciones_propuesta'] = $this->calificaciones_propuesta_model->get_calificaciones_propuesta_propuesta_evaluacion($id_propuesta_evaluacion, $cve_dependencia, $cve_rol);
            $data['calificacion_final_propuesta_evaluacion'] = $this->calificaciones_propuesta_model->get_calificacion_final_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['num_calificaciones_propuesta_dependencia'] = $this->calificaciones_propuesta_model->get_num_calificaciones_propuesta_dependencia($id_propuesta_evaluacion, $cve_dependencia);
            $data['id_propuesta_evaluacion'] = $id_propuesta_evaluacion;
            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();
            $data['error'] = $this->session->flashdata('error');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/dlg_borrar');
            $this->load->view('propuestas_evaluacion/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo($id_proyecto)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;

            $data['tipos_evaluacion'] = $this->tipos_evaluacion_model->get_tipos_evaluacion();
            $data['justificaciones_evaluacion'] = $this->justificaciones_evaluacion_model->get_justificaciones_evaluacion();
            $data['id_proyecto'] = $id_proyecto;

            $this->load->view('templates/header', $data);
            $this->load->view('propuestas_evaluacion/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->input->post();
            if ($propuesta_evaluacion) {

                $id_propuesta_evaluacion = $propuesta_evaluacion['id_propuesta_evaluacion'];
                if ($id_propuesta_evaluacion) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'cve_dependencia' => $propuesta_evaluacion['cve_dependencia'],
                    'id_tipo_evaluacion' => empty($propuesta_evaluacion['id_tipo_evaluacion']) ? null : $propuesta_evaluacion['id_tipo_evaluacion'],
                    'otro_tipo_evaluacion' => $propuesta_evaluacion['otro_tipo_evaluacion'],
                    'id_justificacion_evaluacion' => empty($propuesta_evaluacion['id_justificacion_evaluacion']) ? null : $propuesta_evaluacion['id_justificacion_evaluacion'],
                    'otra_justificacion_evaluacion' => $propuesta_evaluacion['otra_justificacion_evaluacion'],
                    'objetivo' => $propuesta_evaluacion['objetivo'],
                    'recursos_propios' => $propuesta_evaluacion['recursos_propios'],
                    'monto' => empty($propuesta_evaluacion['monto']) ? null : $propuesta_evaluacion['monto'],
                    'observaciones' => $propuesta_evaluacion['observaciones'],
                    'recomendaciones_previas' => empty($propuesta_evaluacion['recomendaciones_previas']) ? 0 : $propuesta_evaluacion['recomendaciones_previas'],
                    'justificacion_no_atencion' => $propuesta_evaluacion['justificacion_no_atencion'],
                    'info_diagnostico' => empty($propuesta_evaluacion['info_diagnostico']) ? null : $propuesta_evaluacion['info_diagnostico'],
                    'info_mir' => empty($propuesta_evaluacion['info_mir']) ? null : $propuesta_evaluacion['info_mir'],
                    'info_reglasop' => empty($propuesta_evaluacion['info_reglasop']) ? null : $propuesta_evaluacion['info_reglasop'],
                    'info_regsadm' => empty($propuesta_evaluacion['info_regsadm']) ? null : $propuesta_evaluacion['info_regsadm'],
                    'info_fuentes_of' => empty($propuesta_evaluacion['info_fuentes_of']) ? null : $propuesta_evaluacion['info_fuentes_of'],
                    'info_progpresup' => empty($propuesta_evaluacion['info_progpresup']) ? null : $propuesta_evaluacion['info_progpresup'],
                    'info_padronben' => empty($propuesta_evaluacion['info_padronben']) ? null : $propuesta_evaluacion['info_padronben'],
                    'info_lineamientos' => empty($propuesta_evaluacion['info_lineamientos']) ? null : $propuesta_evaluacion['info_lineamientos'],
                    'info_guiasop' => empty($propuesta_evaluacion['info_guiasop']) ? null : $propuesta_evaluacion['info_guiasop'],
                    'info_normativa' => empty($propuesta_evaluacion['info_normativa']) ? null : $propuesta_evaluacion['info_normativa'],
                    'info_otro' => empty($propuesta_evaluacion['info_otro']) ? null : $propuesta_evaluacion['info_otro'],
                    'otra_info_disponible' => $propuesta_evaluacion['otra_info_disponible'],
                    'id_proyecto' => $propuesta_evaluacion['id_proyecto'],
                );
                $id_propuesta_evaluacion = $this->propuestas_evaluacion_model->guardar($data, $id_propuesta_evaluacion);

                // registro en bitacora
                $entidad = 'propuestas_evaluacion';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('proyectos/detalle/'.$propuesta_evaluacion['id_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

    public function guardar_clasificacion()
    {
        if ($this->session->userdata('logueado')) {

            $propuesta_evaluacion = $this->input->post();
            if ($propuesta_evaluacion) {

                $id_propuesta_evaluacion = $propuesta_evaluacion['id_propuesta_evaluacion'];

                // guardado
                $data = array(
                    'clasificacion_supervisor' => $propuesta_evaluacion['clasificacion_supervisor'],
                    'excluir_agenda' => $propuesta_evaluacion['excluir_agenda'],
                    'comentarios_exclusion' => $propuesta_evaluacion['comentarios_exclusion'],
                );
                $id_propuesta_evaluacion = $this->propuestas_evaluacion_model->guardar($data, $id_propuesta_evaluacion);

                // registro en bitacora
                $entidad = 'propuestas_evaluacion';
                $accion = 'modificó';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            }

            redirect('proyectos/detalle/'.$propuesta_evaluacion['id_proyecto']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $periodo = $data['userdata']['anio_sesion'];

            $propuesta_evaluacion = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $periodo);
            $id_proyecto = $propuesta_evaluacion['id_proyecto'];
            $calificaciones = $this->calificaciones_propuesta_model->get_calificaciones_propuesta_propuesta_evaluacion($id_propuesta_evaluacion);
            if ($calificaciones) {
                $this->session->set_flashdata('err_propuestas_evaluacion', 'Esta propuesta ya está calificada, no se puede eliminar');
            } else {
                // registro en bitacora
                $accion = 'eliminó';
                $entidad = 'propuestas_evaluacion';
                $valor = $id_propuesta_evaluacion . " " . $propuesta_evaluacion['cve_proyecto'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

                // eliminado
                $this->propuestas_evaluacion_model->eliminar($id_propuesta_evaluacion);
            }
            redirect(base_url() . 'proyectos/detalle/' . $id_proyecto);
        } else {
            redirect('inicio/login');
        }
    }

}

