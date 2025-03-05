<?php
class Calificaciones_propuesta extends CI_Controller {
    // globales
    var $etapa_modulo;
    var $nom_etapa_modulo;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('funciones_sistema');

        $this->load->model('calificaciones_propuesta_model');
        $this->load->model('clasificaciones_supervisor_model');
        $this->load->model('probabilidades_inclusion_model');
        $this->load->model('propuestas_evaluacion_model');
        $this->load->model('semaforo_proyectos_model');
        $this->load->model('proyectos_model');

        // globales
        $this->etapa_modulo = 1;
        $this->nom_etapa_modulo = 'planificacion.etapa_activa';
    }

    public function detalle($id_calificacion_propuesta)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];
            $periodo = $data['userdata']['anio_sesion'];

            $data['calificacion_propuesta'] = $this->calificaciones_propuesta_model->get_calificacion_propuesta($id_calificacion_propuesta);
            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();
            $data['probabilidades_inclusion'] = $this->probabilidades_inclusion_model->get_probabilidades_inclusion();
            $proyecto = $this->calificaciones_propuesta_model->get_proyecto($id_calificacion_propuesta);
            $data['num_proyectos_ods'] = $this->proyectos_model->get_num_proyectos_ods($proyecto['periodo']);

            $id_propuesta_evaluacion = $data['calificacion_propuesta']['id_propuesta_evaluacion'];
            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $periodo);
            $data['semaforo_proyecto'] = $this->semaforo_proyectos_model->get_semaforo_proyecto($data['propuesta_evaluacion']['cve_proyecto']);
            $data['ods'] = $this->propuestas_evaluacion_model->get_ods_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['proyecto'] = $this->propuestas_evaluacion_model->get_proyecto($id_propuesta_evaluacion);
            $data['tot_info_disponible'] = $this->propuestas_evaluacion_model->get_tot_info_disponible_propuesta_evaluacion($id_propuesta_evaluacion);

            $this->load->view('templates/header', $data);
            $this->load->view('calificaciones_propuesta/detalle', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function nuevo($id_propuesta_evaluacion)
    {
        if ($this->session->userdata('logueado')) {
            $this->funciones_sistema->recargar_permisos($this->etapa_modulo, $this->nom_etapa_modulo);
            $data['userdata'] = $this->session->userdata;
            $cve_dependencia = $data['userdata']['cve_dependencia'];
            $cve_rol = $data['userdata']['cve_rol'];
            $periodo = $data['userdata']['anio_sesion'];

            $data['clasificaciones_supervisor'] = $this->clasificaciones_supervisor_model->get_clasificaciones_supervisor();
            $data['id_propuesta_evaluacion'] = $id_propuesta_evaluacion;
            $data['cve_dependencia'] = $cve_dependencia;

            $data['propuesta_evaluacion'] = $this->propuestas_evaluacion_model->get_propuesta_evaluacion($id_propuesta_evaluacion, $periodo);
            $data['semaforo_proyecto'] = $this->semaforo_proyectos_model->get_semaforo_proyecto($data['propuesta_evaluacion']['cve_proyecto']);
            $data['ods'] = $this->propuestas_evaluacion_model->get_ods_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['tot_info_disponible'] = $this->propuestas_evaluacion_model->get_tot_info_disponible_propuesta_evaluacion($id_propuesta_evaluacion);
            $data['proyecto'] = $this->propuestas_evaluacion_model->get_proyecto($id_propuesta_evaluacion);
            $data['num_proyectos_ods'] = $this->proyectos_model->get_num_proyectos_ods($data['proyecto']['periodo']);

            $this->load->view('templates/header', $data);
            $this->load->view('calificaciones_propuesta/nuevo', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function guardar()
    {
        if ($this->session->userdata('logueado')) {

            $calificacion_propuesta = $this->input->post();
            if ($calificacion_propuesta) {

                $id_calificacion_propuesta = $calificacion_propuesta['id_calificacion_propuesta'];
                if ($id_calificacion_propuesta) {
                    $accion = 'modificó';
                } else {
                    $accion = 'agregó';
                }

                // guardado
                $data = array(
                    'id_propuesta_evaluacion' => $calificacion_propuesta['id_propuesta_evaluacion'],
                    'cve_dependencia' => $calificacion_propuesta['cve_dependencia'],
                    'evaluacion_obligatoria' => $calificacion_propuesta['evaluacion_obligatoria'],
                    'agenda2030' => $calificacion_propuesta['agenda2030'],
                    'pertinencia_evaluacion' => $calificacion_propuesta['pertinencia_evaluacion'],
                    'ciclo_evaluativo' => $calificacion_propuesta['ciclo_evaluativo'],
                    'recomendaciones_previas' => $calificacion_propuesta['recomendaciones_previas'],
                    'justificacion_no_atencion' => $calificacion_propuesta['justificacion_no_atencion'],
                    'informacion_disponible' => $calificacion_propuesta['informacion_disponible'],
                    'clasificacion_supervisor' => $calificacion_propuesta['clasificacion_supervisor'],
                    'comentarios' => $calificacion_propuesta['comentarios'],
                    'criterio_institucional' => $calificacion_propuesta['criterio_institucional']
                );
                $id_calificacion_propuesta = $this->calificaciones_propuesta_model->guardar($data, $id_calificacion_propuesta);

                // registro en bitacora
                $entidad = 'calificaciones_propuesta';
                $valor = $id_calificacion_propuesta . " " . $calificacion_propuesta['cve_dependencia'];
                $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);
            }

            redirect('propuestas_evaluacion/detalle/'.$calificacion_propuesta['id_propuesta_evaluacion']);

        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($id_calificacion_propuesta)
    {
        if ($this->session->userdata('logueado')) {

            // registro en bitacora
            $calificacion_propuesta = $this->calificaciones_propuesta_model->get_calificacion_propuesta($id_calificacion_propuesta);
            $accion = 'eliminó';
            $entidad = 'calificaciones_propuesta';
            $valor = $id_calificacion_propuesta . " " . $calificacion_propuesta['cve_proyecto'];
            $this->funciones_sistema->registro_bitacora($accion, $entidad, $valor);

            // eliminado
            $this->calificaciones_propuesta_model->eliminar($id_calificacion_propuesta);

            redirect('propuestas_evaluacion/detalle/'.$calificacion_propuesta['id_propuesta_evaluacion']);

        } else {
            redirect('inicio/login');
        }
    }

}
