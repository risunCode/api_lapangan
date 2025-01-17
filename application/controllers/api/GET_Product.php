<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class GET_Product extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);

        // Mengizinkan semua origin untuk mengakses API
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header("Access-Control-Allow-Origin: http://localhost:3000");

        
        // Mengatasi preflight request untuk CORS
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            header("HTTP/1.1 200 OK");
            exit;
        }
        
        $this->load->database();
    }

    // Fungsi untuk menangani request GET
    function index_get()
    {
        $id_item = $this->get('id_item');
        
        if ($id_item !== null) {
            // Filter berdasarkan id_item jika ada
            $this->db->where('id_item', $id_item);
        } else {
            // Urutkan berdasarkan tanggal_input secara descending jika id_item tidak ada
            $this->db->order_by('tanggal_input', 'DESC');
        }

        // Ambil data produk dari database
        $api = $this->db->get('product')->result();

        // Periksa apakah ada data yang ditemukan
        if (!empty($api)) {
            // Kirimkan response dengan data produk
            $this->response($api, 200);
        } else {
            // Jika tidak ada data, kirimkan response 404 Not Found
            $this->response(['message' => 'Produk tidak ditemukan'], 404);
        }
    }

    // Fungsi untuk menangani request PUT
    function index_put()
    {
        // PUT biasanya untuk update resource, tapi saat ini hanya untuk meniru GET
        $api = $this->db->get('product')->result();
        $this->response($api, 200);
    }

    // Fungsi untuk menangani request POST
    function index_post()
    {
        // POST biasanya untuk membuat resource baru, tapi saat ini hanya untuk meniru GET
        $api = $this->db->get('product')->result();
        $this->response($api, 200);
    }
}
