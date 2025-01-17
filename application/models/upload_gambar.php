<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class upload_gambar extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengunggah gambar dari form input.
     */
    public function upload_image($id_item, $field_name = 'gambar') {
        $upload_path = FCPATH . 'assets/product/uploads/';
    
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }
    
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 8024; // Dalam kilobyte
        $config['file_name'] = $id_item . '_' . time();
    
        $this->load->library('upload', $config);
        $this->load->helper('security');
    
        if (!isset($_FILES[$field_name])) {
            return ['error' => 'No file uploaded.', 'status_code' => 400];
        }
    
        if (!$this->upload->do_upload($field_name)) {
            $error = $this->upload->display_errors('', '');
            return ['error' => $error, 'status_code' => 400];
        }

        $upload_data = $this->upload->data();
        $file_name = $upload_data['file_name'];
        $full_path = $config['upload_path'] . $file_name;

        // Simpan nama file ke database
        $data = ['gambar' => $file_name];
        $this->db->where('id_item', $id_item);
        $this->db->update('product', $data);

        return [
            'success' => true,
            'file_name' => $file_name,
            'full_path' => $full_path,
            'status_code' => 201
        ];
    }

    /**
     * Mendapatkan gambar berdasarkan ID item.
     */
    public function get_image_by_id($id_item) {
        $this->db->select('gambar');
        $this->db->where('id_item', $id_item);
        $query = $this->db->get('product'); // Diperbaiki nama tabel
        return $query->row_array();
    }

    /**
     * Mengunggah gambar dari URL.
     */
    public function upload_from_url($image_url, $id_item) {
        $upload_path = FCPATH . 'assets/product/uploads/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        // Validasi URL
        if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
            return ['error' => 'Invalid URL.', 'status_code' => 400];
        }

        $file_name = $id_item . '_' . time() . '.jpg'; // Format file default JPG
        $full_path = $upload_path . $file_name;

        // Unduh gambar
        $ch = curl_init($image_url);
        $fp = fopen($full_path, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Tambahkan timeout
        $success = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);

        // Hapus file jika unduhan gagal
        if (!$success || $http_code !== 200) {
            if (file_exists($full_path)) {
                unlink($full_path);
            }
            return ['error' => 'Failed to download image from URL.', 'status_code' => 400];
        }

        // Simpan nama file ke database
        $data = ['gambar' => $file_name];
        $this->db->where('id_item', $id_item);
        $this->db->update('product', $data);

        return [
            'success' => true,
            'file_name' => $file_name,
            'full_path' => $full_path,
            'status_code' => 201
        ];
    }
}
