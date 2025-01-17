<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DemoControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('DemoProductModel');
    }

    public function index() {
        $data['products'] = $this->DemoProductModel->getAllProducts();

        // Tidak perlu mendownload gambar ke server, cukup menggunakan URL yang ada
        $this->load->view('v_DemoMainPage', $data);
    }
}
