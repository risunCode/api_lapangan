<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH . '/libraries/REST_Controller.php';

class registrasi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('form_validation');
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") die();
    }
    public function index_post()
    {        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        if ($this->form_validation->run() == FALSE) return $this->response(['status' => FALSE, 'message' => validation_errors()], REST_Controller::HTTP_BAD_REQUEST);
        
        $email = strip_tags($this->input->post('email'));
        $cek = $this->db->get_where('user', ['email' => $email])->row();
        if ($cek) return $this->response(['status' => FALSE, 'message' => 'Email sudah terdaftar.'], REST_Controller::HTTP_BAD_REQUEST);
        
        $hashed_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $userData = [
            'nama' => strip_tags($this->input->post('nama')),
            'email' => $email,
            'password' => $hashed_password,
            'created_at' => date('Y-m-d H:i:s'),
            'role_id' => 2, // Assuming 2 is the user role ID
            'is_active' => 1
        ];
        
        $this->db->insert('user', $userData);
        $insert_id = $this->db->insert_id();
        
        if ($this->db->affected_rows() > 0) {
            return $this->response([
                'status' => TRUE,
                'message' => 'Registrasi berhasil!',
                'data' => [
                    'id' => $insert_id,
                    'nama' => $userData['nama'],
                    'email' => $userData['email']
                ]
            ], REST_Controller::HTTP_OK);
        } else {
            return $this->response([
                'status' => FALSE,
                'message' => 'Terjadi kesalahan, silakan coba lagi.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
