<?php
class Reportes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('accesos_sistema_model');
        $this->load->model('opciones_sistema_model');
        $this->load->model('bitacora_model');

        $this->load->model('proyectos_model');
        $this->load->model('parametros_sistema_model');
        $this->load->model('dependencias_model');
        $this->load->model('probabilidades_inclusion_model');
        $this->load->model('evaluadores_model');
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

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $data['periodo'] = $this->parametros_sistema_model->get_parametro_sistema_nom('anio_propuestas');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_programas_agenda_evaluacion_01()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $data['programas_agenda_evaluacion'] = $this->proyectos_model->get_programas_agenda_evaluacion($cve_dependencia);

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/listado_programas_agenda_evaluacion_01', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_programas_agenda_evaluacion_01_csv()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $sql = ""
                ."select "
                ."d.nom_dependencia, pg.cve_programa, pg.nom_programa, pe.cve_proyecto,  "
                ."py.nom_proyecto, dpe.nom_dependencia as nom_dependencia_propuesta, "
                ."te.nom_tipo_evaluacion, cs.nom_clasificacion_supervisor, pcp.puntaje, pcp.probabilidad "
                ."from "
                ."propuestas_evaluacion pe  "
                ."left join proyectos py on pe.cve_proyecto = py.cve_proyecto "
                ."left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia "
                ."left join dependencias d on py.cve_dependencia = d.cve_dependencia "
                ."left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion "
                ."left join puntaje_calificacion_propuesta pcp on py.cve_proyecto = pcp.cve_proyecto and pe.id_propuesta_evaluacion = pcp.id_propuesta_evaluacion "
                ."left join clasificaciones_supervisor cs on pe.clasificacion_supervisor = cs.cve_clasificacion_supervisor  "
                ."left join dependencias dpe on pe.cve_dependencia = dpe.cve_dependencia "
                ."where "
                ."py.cve_dependencia::text LIKE '%' "
                ."and coalesce(pe.excluir_agenda,0) <> 1 "
                ."order by "
                ."d.nom_dependencia, pg.cve_programa, pe.cve_proyecto, pe.id_propuesta_evaluacion "
                ."";
            $query = $this->db->query($sql, array($cve_dependencia));

            $delimiter = ",";
            $newline = "\r\n";
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("programas_agenda_anual_evaluacion.csv", $data);
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_propuestas_evaluacion_01()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $data['propuestas_evaluacion'] = $this->proyectos_model->get_propuestas_evaluacion($cve_dependencia);

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/listado_propuestas_evaluacion_01', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_propuestas_evaluacion_01_csv()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
			$sql = ''
				.'select  '
				.'d.nom_dependencia, pg.cve_programa, pg.nom_programa, pe.cve_proyecto,  '
				.'py.nom_proyecto, te.nom_tipo_evaluacion '
				.'from  '
				.'propuestas_evaluacion pe  '
				.'left join proyectos py on pe.cve_proyecto = py.cve_proyecto  '
				.'left join programas pg on py.cve_programa = pg.cve_programa and py.cve_dependencia = pg.cve_dependencia '
				.'left join dependencias d on py.cve_dependencia = d.cve_dependencia '
				.'left join tipos_evaluacion te on pe.id_tipo_evaluacion = te.id_tipo_evaluacion '
				.'where  '
				.'py.cve_dependencia::text LIKE ? '
				.'order by '
				.'d.nom_dependencia, pg.cve_programa, pe.cve_proyecto  '
				.'';
			$query = $this->db->query($sql, array($cve_dependencia));

            $delimiter = ",";
            $newline = "\r\n";
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("propuestas_evaluacion.csv", $data);
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_status_dependencias()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $filtros = $this->input->post();
            if ($filtros) {
                $evaluaciones = $filtros['evaluaciones'];
                $propuestas = $filtros['propuestas'];
            } else {
                $evaluaciones = '';
                $propuestas = '';
            }

            $data['evaluaciones'] = $evaluaciones;
            $data['propuestas'] = $propuestas;

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $data['status_dependencias'] = $this->dependencias_model->get_status_dependencias($evaluaciones, $propuestas);

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/listado_status_dependencias', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_status_dependencias_csv()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');

            if ($cve_rol != 'usr') {
                $cve_dependencia = '%';
            }
            $sql = 'select nom_dependencia, nom_completo_dependencia from dependencias where carga_evaluaciones = 0 ;';
			$query = $this->db->query($sql);

            $delimiter = ",";
            $newline = "\r\n";
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("status_dependencias.csv", $data);
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_bitacora_01()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $filtros = $this->input->post();
            if ($filtros) {
                $accion = $filtros['accion'];
                $entidad = $filtros['entidad'];
            } else {
                $accion = '';
                $entidad = '';
            }

            $data['accion'] = $accion;
            $data['entidad'] = $entidad;

            $nom_dependencia = $this->session->userdata['nom_dependencia'];
            $data['bitacora'] = $this->bitacora_model->get_bitacora($nom_dependencia, $cve_rol, $accion, $entidad);

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/listado_bitacora_01', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_bitacora_01_csv()
    {
        if ($this->session->userdata('logueado')) {
            $data = [];
            $data += $this->get_userdata();
            $cve_dependencia = $data['cve_dependencia'];
            $cve_rol = $data['cve_rol'];

            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');

            $filtros = $this->input->post();
            if ($filtros) {
                $accion = $filtros['accion'];
                $entidad = $filtros['entidad'];
            } else {
                $accion = '';
                $entidad = '';
            }

            if ($cve_rol == 'adm') {
                $nom_dependencia = '%';
            }

            $sql = "select b.* from bitacora b where b.nom_dependencia LIKE ? ";
            $parametros = array();
            array_push($parametros, "$nom_dependencia");
            if ($accion <> "") {
                $sql .= ' and b.accion = ?';
                array_push($parametros, "$accion");
            } 
            if ($entidad <> "") {
                $sql .= ' and b.entidad = ?';
                array_push($parametros, "$entidad");
            } 
            $sql .= ' order by b.cve_evento desc;';
            $query = $this->db->query($sql, $parametros);

            $delimiter = ",";
            $newline = "\r\n";
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("listado_bitacora_01.csv", $data);
        } else {
            redirect('inicio/login');
        }
    }

    public function listado_evaluadores($salida='')
    {
        if ($this->session->userdata('logueado')) {
            $this->load->helper('file');
            $this->load->helper('download');

            $data = [];
            $data += $this->get_userdata();

            $data['evaluadores'] = $this->evaluadores_model->get_listado_evaluadores($salida);

            if ($salida == 'csv') {
                force_download("listado_evaluadores.csv", $data['evaluadores']);
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('reportes/listado_evaluadores', $data);
                $this->load->view('templates/footer');
            }
        } else {
            redirect('inicio/login');
        }
    }


}
