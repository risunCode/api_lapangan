<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class PUT_product extends REST_Controller
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
        $this->load->model('product');
    }

    // Handle PUT request to update item
    function index_put()
    {
        // Ambil id_item dari parameter atau PUT data
        $id_item = $this->get('id_item') ? $this->get('id_item') : $this->put('id_item');
        if (empty($id_item)) {
            $this->response([
                'status' => FALSE,
                'message' => 'ID item tidak ditemukan.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        // Validasi dan proses update
        // Pastikan id_item tidak kosong dan ada data untuk diperbarui
        if (!empty($id_item) && (!empty($this->put('nama_item')) || !empty($this->put('deskripsi')))) {
            // Lakukan pengecekan apakah item ada di database
            $item = $this->product->getById($id_item);
            if (!$item) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Item not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
                return;
            }
    
            // Melakukan pembaruan item
            $itemData = array();
            if ($this->put('nama_item')) $itemData['nama_item'] = strip_tags($this->put('nama_item'));
            // Proses lainnya sesuai data yang ada
    
            // Update produk
            $update = $this->product->update($itemData, $id_item);
            if ($update) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Item updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response("Gagal memperbarui item, silakan coba lagi.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response("Data tidak valid. Setidaknya satu field harus diubah dan ID item valid.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Handle GET request to retrieve item (example implementation)
    function index_get()
    {
        $id_item = $this->get('id_item');

        if (!empty($id_item)) {
            $item = $this->product->getById($id_item);

            if ($item) {
                $this->response([
                    'status' => TRUE,
                    'data' => $item
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Item not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}
