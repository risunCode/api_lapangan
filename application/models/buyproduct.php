<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class buyproduct extends CI_Model {

    protected $table = 'buydetail';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
 
    public function get_all($filters = [])
    {
        if (!empty($filters)) {
            $this->db->where($filters);
        }
        return $this->db->get($this->table)->result();
    }

    /**
     * Ambil data beli berdasarkan ID
     * @param int $id
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Tambahkan data baru ke tabel beli
     * @param array $data
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data) ? $this->db->insert_id() : false;
    }

    /**
     * Perbarui data beli berdasarkan ID
     * @param array $data
     * @param int $id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Hapus data beli berdasarkan ID
     * @param int $id
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}