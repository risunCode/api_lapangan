<?php
defined('BASEPATH') or exit('No direct script access allowed');
include 'application/models/modal.php'; 
$this->load->library('session'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lapangan API!</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #FFF;
            margin: 40px;
            font: 16px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
            word-wrap: break-word;
        }

        a {
            color: #039;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 24px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 16px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body {
            margin: 0 15px 0 15px;
        }

        p.footer {
            text-align: right;
            font-size: 16px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

    #preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        /* Memberi jarak antara form dan preview */
    }

    #preview {
        border: 1px solid #ddd;
        /* Memberikan border pada thumbnail */
        border-radius: 5px;
        /* Membuat sudut melengkung */
        object-fit: cover;
        /* Menjaga aspek rasio gambar */
    }

    /* CSS Kustom untuk memastikan modal tetap responsif */
    @media (min-width: 768px) {
        .modal-dialog {
            width: 75%;
            /* Lebar modal pada desktop */
        }
    }

    @media (max-width: 767px) {
        .modal-dialog {
            width: 100%;
            /* Lebar modal pada mobile */
        }
    }
    </style>
</head>

<body>
    <div id="container">
        <h1>Welcome to REST API Aplikasi Lapangan!</h1>


        <div class="alert alert-info" role="alert">
            <?php if ($this->session->has_userdata('email')): ?>
                <h3>Welcome, <?= htmlspecialchars($this->session->userdata('email')); ?>!</h3>
            <?php else: ?>
                <h3>Welcome, Guest!</h3>
            <?php endif; ?>
        </div>

        <div id="body">
            <h2><a href="<?= site_url(); ?>">Home</a></h2>

            <ul>
                <li><a href="<?= site_url('/api/user'); ?>">GET DATA USER</a></li>
                <li><a href="<?= site_url('/api/product/PUT_item'); ?>">PUT UNTUK ITEM</a></li>
                <li><a href="<?= site_url('/api/product/GET_item'); ?>">GET Daftar Produk</a></li>
                <li><a href="<?= site_url('DemoControl'); ?>">(DEMO) LIHAT HALAMAN PRODUK</a></li>
            <!-- <?php if (!isset($apiKey) || empty($apiKey)) : ?>
                <div class="alert alert-warning" role="alert">API Key is missing!</div>
            <?php endif; ?> -->
 
 

            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalRegister">Register (POST)</button>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalLojin">Login User (POST)</button>

            <form action="<?= site_url('/api/product/DELETE_item'); ?>" method="get" class="form-inline">
                <div class="form-group mb-2">
                    <label for="id_item" class="sr-only">Hapus Produk ID:</label>
                    <input type="text" class="form-control" id="id_item" name="id_item" placeholder="Hapus by ID Produk" required>
                </div>
                <button type="submit" class="btn btn-danger mb-2 ml-2">Hapus Produk</button> <span class="text-muted"></span>
            </form>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalsendGambar">Tambah Produk (POST)</button>


            <a href="<?= base_url('api/logout'); ?>" class="btn btn-primary mb-3">Logout</a>

        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?= (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

        <?php if ($this->session->flashdata('success')): ?>
        <script>
        Swal.fire({
            title: "Berhasil!",
            text: "<?= $this->session->flashdata('success'); ?>",
            icon: "success"
        });
        </script>
        <?php endif; ?> 
        

        <?php if ($this->session->flashdata('error')): ?>
        <script>
        let timerInterval;
        Swal.fire({
            title: "Error!",
            icon: "error",
            html: "Pesan ini akan tertutup dalam <b></b> milliseconds.",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log("I was closed by the timer");
            }
        });
        </script>
        <?php endif; ?>

        <!-- Menampilkan pesan flashdata success dan error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>


    <script>
        // Create an 'App' namespace
        var App = App || {};

        // Basic rest module using an IIFE as a way of enclosing private variables
        App.rest = (function restModule(window) {
            var _alert = window.alert;
            var _JSON = window.JSON;
            var _$ajax = null;
            var $ = null;

            function _ajaxDone(data) {
                _alert(_JSON.stringify(data, null, 2));
            }

            function _ajaxFail() {
                _alert('Oh no! A problem with the Ajax request!');
            }

            function _ajaxEvent($element) {
                $.ajax({
                        url: $element.attr('href')
                    })
                    .done(_ajaxDone)
                    .fail(_ajaxFail);
            }

            function _bindEvents() {
                _$ajax.on('click.app.rest.module', function(event) {
                    event.preventDefault();
                    _ajaxEvent($(this));
                });
            }

            function _cacheDom() {
                _$ajax = $('#ajax');
            }

            return {
                init: function init(jQuery) {
                    $ = jQuery;
                    _cacheDom();
                    _bindEvents();
                }
            };
        }(window));

        $(function domReady($) {
            App.rest.init($);
        });

        const toggle = document.querySelector(".toggle"),
            input = document.querySelector(".password");
        toggle.addEventListener("click", () => {
            if (input.type === "password") {
                input.type = "text";
                toggle.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                input.type = "password";
            }
        });
</script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    // SweetAlert untuk tombol view image
    const buttons = document.querySelectorAll('.view-image-btn');
    const modalImage = document.getElementById('modalImage');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const imageUrl = this.getAttribute('data-image');
            modalImage.src = imageUrl;
        });
    });

    // Preview gambar saat upload
    const fileInput = document.getElementById('gambar');
    const preview = document.getElementById('preview');
    const sizeInfo = document.getElementById('size-info');

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];

            if (file) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2); // Convert byte ke MB
                sizeInfo.textContent = `Ukuran gambar: ${fileSizeMB} MB`;
                sizeInfo.style.display = 'block';

                if (file.size > 2 * 1024 * 1024) { // Jika lebih dari 2MB
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Ukuran gambar melebihi 2MB. Harap pilih gambar yang lebih kecil.",
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                sizeInfo.style.display = 'none';
            }
        });
    }

    // SweetAlert untuk tombol hapus
    const deleteButtons = document.querySelectorAll(".btn-hapus");
    deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute("data-url");
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini tidak dapat dikembalikan setelah dihapus!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    // SweetAlert untuk flashdata
    const flashMessages = {
        success: "<?php echo $this->session->flashdata('success'); ?>",
        error: "<?php echo $this->session->flashdata('error'); ?>",
        warning: "<?php echo $this->session->flashdata('warning'); ?>"
    };

    Object.keys(flashMessages).forEach(type => {
        if (flashMessages[type]) {
            Swal.fire({
                title: type === "success" ? "Berhasil!" : "Gagal",
                text: flashMessages[type],
                icon: type, // Menggunakan tipe flashdata sebagai icon SweetAlert
                timer: 3000,
                timerProgressBar: true, 
            });
        }
    });
}); 

document.getElementById('togglePassword').addEventListener('click', function () {
    var passwordField = document.getElementById('password');
    var passwordFieldType = passwordField.getAttribute('type');
    if (passwordFieldType === 'password') {
        passwordField.setAttribute('type', 'text');
        document.getElementById('togglePassword').innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
        passwordField.setAttribute('type', 'password');
        document.getElementById('togglePassword').innerHTML = '<i class="fa fa-eye"></i>';
    }
});

document.getElementById('toggleLoginPassword').addEventListener('click', function () {
    var loginPasswordField = document.getElementById('login_password');
    var loginPasswordFieldType = loginPasswordField.getAttribute('type');
    if (loginPasswordFieldType === 'password') {
        loginPasswordField.setAttribute('type', 'text');
        document.getElementById('toggleLoginPassword').innerHTML = '<i class="fa fa-eye-slash"></i>';
    } else {
        loginPasswordField.setAttribute('type', 'password');
        document.getElementById('toggleLoginPassword').innerHTML = '<i class="fa fa-eye"></i>';
    }
});
</script>
    <script>
        $(document).ready(function() {
            $('#gambar').on('input', function() {
                var imageUrl = $(this).val();
                $('#preview').attr('src', imageUrl);
                $('#preview').show();
            });
        });
    </script>
