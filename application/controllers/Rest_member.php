<?php
defined('BASEPATH') or exit('No Direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Rest_member extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id_user = $this->get('id_user');
        $this->response($id_user ? $this->db->get_where('member', ['id_user' => $id_user])->result() : $this->db->get('member')->result(), 200);
    }

    function index_post() {
        $data = $this->post(); 
        $this->response($this->db->insert('member', $data) ? $data : ['status' => 'fail'], $this->db->affected_rows() ? 201 : 502);
    }

    function index_put() {
        $id_user = $this->put('id_user');
        $data = $this->put();
        $this->db->where('id_user', $id_user);
        $this->response($this->db->update('member', $data) ? ['status' => 'update success'] : ['status' => 'fail'], $this->db->affected_rows() ? 200 : 502);
    }

    function index_delete() {
        $id_user = $this->delete('id_user');
        $this->db->where('id_user', $id_user);
        $this->response($this->db->delete('member') ? ['status' => 'delete success'] : ['status' => 'fail'], $this->db->affected_rows() ? 200 : 502);
    }
}   