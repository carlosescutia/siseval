<?php
class Archivos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

    }

    public function enviar()
    {
        if ($this->session->userdata('logueado')) {
            $nombre_archivo = $this->input->post('nombre_archivo');
            $config = array();
            $config['upload_path'] = 'oficios';
            $config['allowed_types'] = 'pdf';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $nombre_archivo;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('subir_archivo') ) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                $this->session->set_flashdata('error', $error['error']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->login();
        }
    }

}
