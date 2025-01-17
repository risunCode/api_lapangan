<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
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

    //Menampilkan hasil loping login akun user
    function index_get()
    {
        $id = $this->get('id_user'); // Use 'id_user' consistently

        if ($id == '') {
            $users = $this->db->get('user')->result_array(); // Use result_array() for JSON
            $this->response([
                'status' => true,
                'message' => 'Semua data user berhasil di dapatkan!',
                'data' => $users
            ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'User not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    } 
  

    function index_post()
    {
        $data = array(
            'id_user' => $this->post('id_user'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'password' => password_hash($this->post('password'), PASSWORD_BCRYPT),
            'role_id' => $this->post('role_id'),
            'is_active' => $this->post('is_active'),
            'created_at' => date('Y-m-d')
        );
        $insert = $this->db->insert('user', $data);
        if ($insert) {
            $this->response([
                'message' => 'Data user berhasil ditambahkan',
                'data' => $data
            ], 201);
        } else {
            $this->response(['status' => 'fail'], 502);
        }
    }

    function index_put()
    {
        $id_user = $this->put('id_user');
        $data = array(
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'password' => password_hash($this->put('password'), PASSWORD_BCRYPT),
            'role_id' => $this->put('role_id'),
            'is_active' => $this->put('is_active'),
            'modified' => date('Y-m-d')
        );
        $this->db->where('id_user', $id_user);
        $update = $this->db->update('user', $data);
        if ($update) {
            $this->response([
                'message' => 'Data user berhasil diperbarui',
                'data' => $data
            ], 200);
        } else {
            $this->response(['status' => 'fail'], 502);
        }
    }

    function index_delete()
    {
        $id_user = $this->delete('id_user');
        if ($id_user == null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id_user'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        $this->db->where('id_user', $id_user);
        $delete = $this->db->delete('user');
        if ($delete) {
            $this->response([
                'status' => true,
                'message' => 'user berhasil dihapus'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to delete'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
