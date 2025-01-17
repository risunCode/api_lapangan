<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Mengambil semua produk
    public function get_all_products() {
        $query = $this->db->get('product');
        return $query->result_array();
    }

    // Mengambil produk berdasarkan ID
    public function get_product_by_id($id_item) {
        $query = $this->db->get_where('product', array('id_item' => $id_item));
        return $query->row_array();
    }

    // Menambahkan produk baru
    public function insert_product($data) {
        return $this->db->insert('product', $data);
    }

    // Memperbarui produk berdasarkan ID
    public function update_product($id_item, $data) {
        $this->db->where('id_item', $id_item);
        return $this->db->update('product', $data);
    }

    // Menghapus produk berdasarkan ID
    public function delete_product($id_item) {
        $this->db->where('id_item', $id_item);
        return $this->db->delete('product');
    }
}
?>
