<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class DELETE_item extends REST_Controller
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
    }

    function index_delete()
    {
        $id_item = $this->delete('id_item');
        if (!empty($id_item)) {
            // 1. Get the image file name
            $this->db->select('gambar');
            $this->db->where('id_item', $id_item);
            $query = $this->db->get('product');
            $row = $query->row();

            if ($row && !empty($row->gambar)) {
                $image_file_name = $row->gambar;
                $upload_path = FCPATH . 'assets/product/uploads/';  // Correct path
                $file_path = $upload_path . $image_file_name;

                // 2. Delete the image file
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file
                }
            }
 
            // 3. Delete the database record
            $this->db->where('id_item', $id_item);
            $delete = $this->db->delete('product');

            if ($delete) {
                $this->response([
                    'message' => 'Item and image deleted successfully.', // Updated message
                    'status' => 'success'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Failed to delete data. Data may not exist.'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'id_item parameter is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}


