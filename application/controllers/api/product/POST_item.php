<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class POST_item extends REST_Controller
{
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
        $this->load->model('upload_gambar');
        $this->load->model('product');
    }

    public function index_post()
    {
        $nama_item = $this->input->post('nama_item');
        $lokasi = $this->input->post('lokasi');
        $gambar = $this->input->post('gambar'); // Get the image URL directly
    
        // Input validation – including URL validation
        if (empty($nama_item) || empty($lokasi) || empty($gambar)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Nama item, lokasi, dan gambar wajib diisi.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        if (!filter_var($gambar, FILTER_VALIDATE_URL)) {
            $this->response([
                'status' => FALSE,
                'message' => 'URL gambar tidak valid.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        // Check for duplicate entry
        $this->db->where('nama_item', $nama_item);
        $this->db->where('lokasi', $lokasi); // Also check for location
        $existing_item = $this->db->get('product')->row();
    
        if ($existing_item) {
            $this->response([
                'status' => FALSE,
                'message' => 'Data dengan nama dan lokasi yang sama sudah ada.'
            ], REST_Controller::HTTP_CONFLICT);
            return;
        }
    
        // Data to be inserted (gambar now stores the URL as is)
        $data = array(
            'nama_item' => $nama_item,
            'deskripsi' => $this->input->post('deskripsi'),
            'lokasi' => $lokasi,
            'harga' => $this->input->post('harga'),
            'sisa_slot' => $this->input->post('sisa_slot'),
            'gambar' => $gambar,  // Directly store the image URL here
            'created_at' => date('Y-m-d H:i:s')
        );
    
        // Insert data into the database
        $this->db->insert('product', $data);
        $id_item = $this->db->insert_id();
    
        if (!$id_item) {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal menambahkan data.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }
    
        // Image upload and processing (if needed)
        // If you still want to upload and save images, this can be handled here, but it's no longer necessary if you only want to store the URL.
        // $image_data = $this->upload_gambar->upload_from_url($gambar, $id_item);
    
        // if (isset($image_data['error'])) {
        //     $this->response([
        //         'status' => FALSE,
        //         'message' => $image_data['error']
        //     ], REST_Controller::HTTP_BAD_REQUEST);
        //     return;
        // }
    
        // Add ID to the response data
        $data['id_item'] = $id_item;
    
        $this->response([
            'status' => TRUE,
            'message' => 'Data produk berhasil ditambahkan.',
            'data' => $data
        ], REST_Controller::HTTP_CREATED);
    }
    
    public function index_get()
    {
        $id_item = $this->get('id_item');

        if ($id_item === NULL) {
            $items = $this->product->get_all();

            if ($items) {
                $this->response($items, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No items were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $item = $this->product->get_by_id($id_item);

            if ($item) {
                $this->response($item, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Item not found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    } 
}
