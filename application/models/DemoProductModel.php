<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DemoProductModel extends CI_Model {

    protected $table = 'product'; // Replace with your actual table name

    public function __construct() {
        parent::__construct();
    }

    // Fetch all products
    public function getAllProducts() {
        $this->db->select('nama_item, deskripsi, lokasi, harga, sisa_slot, gambar');
        $query = $this->db->get($this->table);

        return $query->result_array(); // Return data as an associative array
    }
}

/* End of file: DemoProductModel.php */
