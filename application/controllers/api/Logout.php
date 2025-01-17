<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Logout extends REST_Controller
{
    public function __construct() // Correct constructor
    {
        parent::__construct();  // Call the parent constructor
        $this->load->library('session'); // Explicitly load session library if this extends a controller that does not load sessions by default
    }


    public function index_get()
    {
        // Hapus data sesi pengguna
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('email'); 
        $this->session->unset_userdata('username'); 
        $this->session->sess_destroy(); 
        $this->session->set_flashdata('warning', 'Anda telah logout.');

        // Add response and redirect (Good Practice)
        $this->response(['message' => 'Logged out successfully'], REST_Controller::HTTP_OK);
        redirect('rest_server');
        $this->session->set_flashdata('success', 'Anda telah Logout!'); 
        
    }
}

