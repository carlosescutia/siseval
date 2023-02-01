<?php
class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->model('accesos_sistema_model');
		$this->load->model('opciones_sistema_model');
		$this->load->model('bitacora_model');
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

			$this->load->view('templates/header', $data);
			$this->load->view('reportes/index', $data);
			$this->load->view('templates/footer');
		} else {
			redirect('inicio/login');
		}
	}

	public function listado_bitacora_01()
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
			redirect('inicio/iniciar_sesion');
		}
	}

	public function listado_bitacora_01_csv()
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
		}
	}

}
