<?php
class Archivos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

        $this->load->model('bitacora_model');

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
            } else {
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'archivos';
                $valor = $nom_dependencia . $separador . $nombre_archivo;
                $accion = 'adjuntó';
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
            } else {
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'archivos';
                $valor = 'propuestas_eval.' . $separador . $nombre_archivo;
                $accion = 'adjuntó';
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
            redirect('propuestas_evaluacion/detalle/'.$id_propuesta_evaluacion);
        } else {
            redirect('inicio/login');
        }
    }

    public function subir()
    {
        if ($this->session->userdata('logueado')) {
            $ruta = $this->input->post('ruta');
            $nombre_archivo = $this->input->post('nombre_archivo');
            $tipo_archivo = $this->input->post('tipo_archivo');
            $config = array();
            $config['upload_path'] = $ruta;
            $config['file_name'] = $nombre_archivo;
            $config['allowed_types'] = $tipo_archivo;
            $config['max_size'] = '10240';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('subir_archivo') ) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                echo 'nombre_archivo: ' . $nombre_archivo ;
                $this->session->set_flashdata('error', $error['error']);
                print_r($this->input->post());
            } else {
                // registro en bitacora
                $separador = ' -> ';
                $usuario = $this->session->userdata('usuario');
                $nom_usuario = $this->session->userdata('nom_usuario');
                $nom_dependencia = $this->session->userdata('nom_dependencia');
                $entidad = 'archivos';
                $valor = $nom_dependencia . $separador . $nombre_archivo;
                $accion = 'subió';
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
            redirect('gestion');
        } else {
            redirect('inicio/login');
        }
    }

    public function eliminar($nombre_archivo)
    {
        if ($this->session->userdata('logueado')) {
            // registro en bitacora
            $separador = ' -> ';
            $usuario = $this->session->userdata('usuario');
            $nom_usuario = $this->session->userdata('nom_usuario');
            $nom_dependencia = $this->session->userdata('nom_dependencia');
            $entidad = 'archivos';
            $valor = $nombre_archivo;
            $accion = 'eliminó';
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

            // Eliminar archivo
            $nombre_archivo_fs = './doc/gestion/' . $nombre_archivo ;
            $status = unlink($nombre_archivo_fs) ? 'Se eliminó el archivo '.$nombre_archivo_fs : 'Error al eliminar el archivo '.$nombre_archivo_fs;
            echo $status;

            redirect('gestion');
        } else {
            redirect('inicio/login');
        }
    }

}
