<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class BUYPOST_item extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('product'); // Model untuk tabel produk

        // CORS setup
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            die();
        }
    }

    public function index_post()
    {
        // Ambil data input dari Postman
        $id_item = (int)$this->post('id_item');
        $jumlah_slot = (int)$this->post('jumlah_slot');
        
        // Validasi input
        if (empty($id_item) || $jumlah_slot <= 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Data input tidak valid. Harap masukkan id_item dan jumlah_slot yang sesuai.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        // Ambil detail produk berdasarkan id_item
        $item = $this->product->get_product_by_id($id_item);
        if (!$item) {
            $this->response([
                'status' => FALSE,
                'message' => 'Produk dengan ID ini tidak ditemukan.'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }
    
        // Cek ketersediaan slot
        if ($item['sisa_slot'] < $jumlah_slot) {
            $this->response([
                'status' => FALSE,
                'message' => 'Slot tidak mencukupi untuk jumlah yang diminta.'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
     
  

        // Ambil harga per slot dari produk (jaga format titik untuk tampilan)
        $harga_per_slot_str = $item['harga']; // Ini tetap menggunakan titik untuk tampilan
        $harga_per_slot = (int)str_replace('.', '', $harga_per_slot_str); // Hapus titik untuk perhitungan

        $harga_total = $harga_per_slot * $jumlah_slot; // Hitung total harga

        // Siapkan data untuk tabel `buydetail`
        $data = [
            'id_item' => $id_item,
            'jumlah_slot' => $jumlah_slot,
            'harga_total' => $harga_total, // Total harga tetap dalam bentuk angka tanpa titik untuk penyimpanan
            'tanggal_pemesanan' => date('Y-m-d H:i:s'),
            'nama_item' => $item['nama_item'], // Menyimpan nama_item
            'lokasi' => $item['lokasi'], // Menyimpan lokasi
            'deskripsi' => $item['deskripsi'] // Menyimpan deskripsi
        ];

        // Simpan data pembelian ke tabel buydetail
        $this->db->insert('buydetail', $data);

        // Jika Anda ingin menampilkan harga dengan titik di response:
        $harga_total_format = number_format($harga_total, 0, ',', '.'); // Format harga dengan titik

    
        // Mulai transaksi database
        $this->db->trans_start();
    
        // Simpan data pembelian ke tabel buydetail
        $this->db->insert('buydetail', $data);
    
        // Ambil id_trx yang dihasilkan
        $id_trx = $this->db->insert_id();
    
        // Update jumlah slot di tabel produk
        $this->db->set('sisa_slot', 'sisa_slot - ' . $jumlah_slot, FALSE); // Decrement sisa_slot
        $this->db->where('id_item', $id_item);
        $this->db->update('product');
    
        // Selesaikan transaksi
        $this->db->trans_complete();
    
        // Cek status transaksi
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Transaksi database gagal: ' . $this->db->last_query());
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal melakukan pembelian.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }
    
        // Cek hasil pembaruan slot produk
        $updated_item = $this->product->get_product_by_id($id_item);
        if ($updated_item['sisa_slot'] != ($item['sisa_slot'] - $jumlah_slot)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal memperbarui jumlah slot produk.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }
    
        // Respon sukses dengan detail item
        $this->response([
            'status' => TRUE,
            'message' => 'Pembelian berhasil.',
            'data' => [
                'id_trx' => $id_trx,
                'id_item' => $id_item,
                'nama_item' => $item['nama_item'], // Nama produk
                'jumlah_slot' => $jumlah_slot,
                'harga_total' => $harga_total,
                'lokasi' => $item['lokasi'], // Lokasi produk
                'deskripsi' => $item['deskripsi'], // Deskripsi produk
                'tanggal_pemesanan' => $data['tanggal_pemesanan']
            ]
        ], REST_Controller::HTTP_CREATED);
    }
}