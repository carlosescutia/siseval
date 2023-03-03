<?php
class Archivos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

    }

    public function oficio_dependencia()
    {
        if ($this->session->userdata('logueado')) {
            $nombre_archivo = $this->input->post('nombre_archivo');
            $config = array();
            $config['upload_path'] = 'oficios';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '10240';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $nombre_archivo;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('subir_archivo') ) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                $this->session->set_flashdata('error', $error['error']);
            }
            redirect('inicio');
        } else {
            redirect('inicio/login');
        }
    }
    public function adjunto_propuesta()
    {
        if ($this->session->userdata('logueado')) {
            $nombre_archivo = $this->input->post('nombre_archivo');
            $id_propuesta_evaluacion = $this->input->post('id_propuesta_evaluacion');
            $config = array();
            $config['upload_path'] = 'adjuntos_propuestas';
            $config['allowed_types'] = 'zip';
            $config['max_size'] = '10240';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $nombre_archivo;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('subir_archivo') ) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $error['error']);
            }
            redirect('propuestas_evaluacion/detalle/'.$id_propuesta_evaluacion);
        } else {
            redirect('inicio/login');
        }
    }

}
