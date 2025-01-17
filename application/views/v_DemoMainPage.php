<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product ListX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 250px;
            padding: 20px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }
        .card p {
            font-size: 0.9em;
            color: #666;
        }
        .card .price {
            font-size: 1.1em;
            color: #27ae60;
            font-weight: bold;
            margin: 10px 0;
        }
        .card .location {
            font-size: 0.9em;
            color: #8e44ad;
            margin: 5px 0;
        }
        .card .slots {
            font-size: 0.9em;
            color: #e74c3c;
            margin: 5px 0;
        }
        .card button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .card .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;  /* Memberikan jarak antara kedua tombol */
        }
        .card button:hover {
            background-color: #2980b9;
        }
        .card button.whatsapp {
            background-color: #27ae60;
            color: white;
        }
        .card button.whatsapp:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <h1>Product List</h1>
    <div class="container">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($product['gambar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image">
                    <h3><?= htmlspecialchars($product['nama_item'], ENT_QUOTES, 'UTF-8'); ?></h3>  
                    <p class="lokasi">Lokasi: <?= htmlspecialchars($product['lokasi'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="deskripsi">Deskripsi: <?= htmlspecialchars($product['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="price">
                        <?php 
                            echo 'Harga: Rp.' . $product['harga']; // Cek nilai harga
                        ?>
                    </p>
                    <p class="slots">Slot tersisa: <?= (int) $product['sisa_slot']; ?></p>

                    <!-- Kontainer untuk kedua tombol -->
                    <div class="button-container">
                        <button>Tambah ke Keranjang</button>                    
                        <a href="https://api.whatsapp.com/send?phone=6281234567890&text=Halo,%20saya%20tertarik%20dengan%20produk%20<?= urlencode($product['nama_item']) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <button class="whatsapp">Hubungi via WhatsApp</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
