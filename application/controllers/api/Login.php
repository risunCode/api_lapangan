    <?php
    defined('BASEPATH') or exit('No direct script access allowed'); 
    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;

    class Login extends REST_Controller
    {

        public function index()
        {
            $this->load->helper('url'); 
        }

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "OPTIONS") {
                die();
            }
            // Load the user model
            $this->load->model('user');
        }
        public function index_post()
        {
            $this->load->library('session');
            $email = $this->post('email');
            $password = $this->post('password');

            // Validate the post data
            if (!empty($email) && !empty($password)) {
            // Check if any user exists with the given email
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'is_active' => 1
            );
            $user = $this->user->getRows($con);

            if ($user && password_verify($password, $user['password'])) {
                // Set the response and exit
                $this->response([
                'is_active' => TRUE,
                'message' => 'User login berhasil bro.',
                'data' => $user
                ], REST_Controller::HTTP_OK);
                $this->session->set_flashdata('success', 'User berhasil Login!');  
            } else {
                // Set the response and exit
                $this->response([
                'is_active' => FALSE,
                'message' => 'Ada kesalahan di email / password.'
                ], REST_Controller::HTTP_BAD_REQUEST); 
            }
            } else {
            // Set the response and exit
            $this->response([
                'is_active' => FALSE,
                'message' => 'Belum mengisi email dan password.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            $this->session->set_flashdata('error', 'Gagal Login Periksa input anda!'); 
            }
        }

        public function index_get()
        {
            // Get the query parameters
            $email = $this->get('email');
            $userid = $this->get('userid');

            // Validate the query parameters
            if (!empty($email) || !empty($userid)) {
            // Check if any user exists with the given email or userid
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'is_active' => 1
            );

            if (!empty($email)) {
                $con['conditions']['email'] = $email;
            }

            if (!empty($userid)) {
                $con['conditions']['id'] = $userid;
            }

            $user = $this->user->getRows($con);

            if ($user) {
                // Set the response and exit
                $this->response([
                'is_active' => TRUE,
                'message' => 'User data retrieved successfully.',
                'data' => $user
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response([
                'is_active' => FALSE,
                'message' => 'User not found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
            } else {
            // Set the response and exit
            $this->response([
                'is_active' => FALSE,
                'message' => 'Email or User ID is required.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        }
