<script src="https://code.jquery.com/jquery-1.12.0.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- BootstrapModal -->
<div id="modalRegister" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Uji coba Register</h4>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('api/Registrasi/index_post') ?>" method="post" enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                    </div> 
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Alamat Email">
                    </div>
                    <div class="form-group">
                        <label for="login_password">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="login_password" name="password" placeholder="Kata Sandi">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                        <button type="reset" class="btn btn-warning" style="background-color: orange;">Reset</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

<!-- BootstrapModal -->
<div id="modalLojin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Login</h4>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('api/Login/index_post') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Alamat Email ">
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <button type="reset" class="btn btn-warning" style="background-color: orange;">Reset Form</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

 

<!-- Bootstrap Modal tambah item -->
<div id="modalsendgambar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Produk</h4>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('api/product/POST_item') ?>" method="post">
                    <!-- Gunakan d-flex untuk tata letak fleksibel -->
                    <div class="d-flex">
                        <!-- Kolom Kiri -->
                        <div class="flex-fill mr-3">
                            <div class="form-group">
                                <label for="nama_item">Nama Produk</label>
                                <input type="text" class="form-control" id="nama_item" name="nama_item" placeholder="Nama Produk" required>
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required>
                            </div>
                            <div class="form-group">
                                <label for="sisa_slot">Sisa Slot</label>
                                <input type="number" class="form-control" id="sisa_slot" name="sisa_slot" placeholder="Sisa Slot" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga Sewa</label>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Sewa" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Masukkan URL Gambar</label>
                                <input type="url" class="form-control" id="gambar" name="gambar" placeholder="Masukkan URL gambar" onchange="previewImage()" required>
                            </div>
                        </div>
                        <!-- Kolom Kanan: Pratinjau Gambar -->
                        <div class="flex-fill text-center">
                            <div id="preview-container">
                                <img id="preview" src="" alt="Preview gambar"
                                    style="display: none; max-width: 100%; max-height: 300px; border: 1px solid #ddd; border-radius: 5px;">
                            </div>
                            <p id="size-info" style="display: none;" class="mt-2"></p>
                        </div>
                    </div>
                    <!-- Tombol Aksi -->
                    <div class="form-group text-right mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning" style="background-color: orange;">Reset</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 