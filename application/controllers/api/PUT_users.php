<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class PUT_users extends REST_Controller
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
        $this->load->model('user');
    }

    // Handle PUT request to update user profile
    function index_put()
    {
        $id = $this->put('id_user');

        // Get the input data
        $nama = strip_tags($this->put('nama'));
        $email = strip_tags($this->put('email'));
        $password = $this->put('password');

        // Validate the input data
        if (!empty($id) && (!empty($nama) || !empty($email) || !empty($password))) {
            // Check if user exists
            $user = $this->user->getById($id);
            if (!$user) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
                return;
            }

            // Prepare data for update
            $userData = array();
            if (!empty($nama)) {
                $userData['nama'] = $nama;
            }
            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->response("Invalid email format.", REST_Controller::HTTP_BAD_REQUEST);
                    return;
                }
                $userData['email'] = $email;
            }
            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $this->response("Password must be at least 8 characters.", REST_Controller::HTTP_BAD_REQUEST);
                    return;
                }
                $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            // Update user data
            $update = $this->user->update($userData, $id);

            if ($update) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'User profile updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response("Failed to update user profile, please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->response("Invalid input. Provide at least one field to update and a valid user ID.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Handle GET request to retrieve user profile (example implementation)
    function index_get()
    {
        $id = $this->get('id_user');

        if (!empty($id)) {
            $user = $this->user->getById($id);

            if ($user) {
                $this->response([
                    'status' => TRUE,
                    'data' => $user
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response("Invalid user ID.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
