<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class GET_item extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    } 
 
    // Menampilkan daftar produk
    public function index_get()
    {
        $id = $this->get('id_item'); // Mendapatkan parameter id_item
        if (empty($id)) {
            $api = $this->db->get('product')->result(); // Semua data
        } else {
            $this->db->where('id_item', $id);
            $api = $this->db->get('product')->result(); // Data berdasarkan ID
        }

        if ($api) {
            $this->response([
                'status' => true,
                'data' => $api
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
/* End of file: Getproduct.php */
 

 