<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class PUT_item extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->set_response_headers();
        $this->load->model('product'); // Pastikan model 'product' sudah terpasang
    }

    private function set_response_headers() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Methods");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

    public function index_put()
    {
        $id_item = $this->put('id_item');
    
        // Get the input data
        $nama_item = strip_tags($this->put('nama_item'));
        $deskripsi = strip_tags($this->put('deskripsi'));
        $lokasi = strip_tags($this->put('lokasi'));
        $harga = strip_tags($this->put('harga'));
        $gambar = strip_tags($this->put('gambar'));
        $sisa_slot = strip_tags($this->put('sisa_slot'));
    
        // Validate the input data
        if (empty($id_item)) {
            $this->response("Provide item ID.", REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        // Only update fields that are provided
        $data = array();
        if (!empty($nama_item)) $data['nama_item'] = $nama_item;
        if (!empty($deskripsi)) $data['deskripsi'] = $deskripsi;
        if (!empty($lokasi)) $data['lokasi'] = $lokasi;
        if (!empty($harga)) $data['harga'] = $harga;
        if (!empty($gambar)) $data['gambar'] = $gambar;
        if (!empty($sisa_slot)) $data['sisa_slot'] = $sisa_slot;
    
        // Validate if there's any field to update
        if (empty($data)) {
            $this->response("No data to update. Provide at least one field.", REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        // Update the product data in the database using the correct method
        $update = $this->product->update_product($id_item, $data);
    
        if ($update) {
            // Fetch the updated item details after the update
            $updated_item = $this->product->get_product_by_id($id_item);
    
            // Return the updated data in the response
            $this->response([
                'status' => TRUE,
                'message' => 'Item berhasil diupdate.',
                'data' => $updated_item // Include the updated data in the response
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Item not found or update failed.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    

    function index_get()
    {
        $id_item = $this->get('id_item');

        if (empty($id_item)) {
            $this->response("Provide item ID.", REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $item = $this->product->getById($id_item);

        if ($item) {
            $this->response([
                'status' => TRUE,
                'data' => $item
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Item tidak ditemukan.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function index_delete()
    {
        //TODO: implement delete function
        $this->response(null, REST_Controller::HTTP_NOT_IMPLEMENTED);
    }
}
