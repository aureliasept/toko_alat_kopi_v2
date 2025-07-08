<?php
// Ambil produk yang sudah ada di file json
$produk_baru = [];
$produk_file = 'produk_dummy.json';
if (file_exists($produk_file)) {
    $produk_baru = json_decode(file_get_contents($produk_file), true) ?: [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $stok = $_POST['stok'] ?? '';
    $satuan = $_POST['satuan'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $img = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['tmp_name']) {
        $img = 'data:' . $_FILES['foto']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
    }
    $produk_baru[] = [
        'nama' => $nama,
        'kategori' => $kategori,
        'harga' => $harga,
        'stok' => $stok,
        'satuan' => $satuan,
        'deskripsi' => $deskripsi,
        'img' => $img
    ];
    file_put_contents($produk_file, json_encode($produk_baru, JSON_PRETTY_PRINT));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f1f3f8 60%, #e0e7ff 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 480px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 24px rgba(106,90,205,0.10);
            padding: 36px 28px 28px 28px;
        }
        h2 {
            text-align: center;
            color: #6a5acd;
            margin-bottom: 24px;
            font-weight: 700;
        }
        form label {
            font-weight: 600;
            color: #333;
        }
        form input, form select, form textarea {
            width: 100%;
            padding: 8px 6px;
            border-radius: 6px;
            border: 1px solid #d1c4e9;
            margin-top: 4px;
            margin-bottom: 16px;
            font-size: 15px;
            font-family: inherit;
        }
        form textarea { resize: vertical; }
        .form-row { display: flex; gap: 10px; }
        .form-row > div { flex: 1; }
        .btn {
            width: 100%;
            padding: 12px 0;
            background: linear-gradient(90deg,#6a5acd,#7b2ff2);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
        }
        .preview-img {
            width: 60px; height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #d1c4e9;
            margin-bottom: 10px;
        }
        .produk-list {
            margin-top: 32px;
        }
        .produk-item {
            display: flex;
            align-items: center;
            background: #f4f4f4;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
            gap: 14px;
        }
        .produk-info {
            flex: 1;
        }
        .produk-nama {
            font-weight: 600;
            color: #6a5acd;
            font-size: 16px;
        }
        .produk-kat {
            font-size: 13px;
            color: #888;
        }
        .produk-harga {
            color: #333;
            font-size: 15px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <form method="POST" enctype="multipart/form-data" id="formTambah">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">Pilih kategori</option>
                <option>Kopi</option>
                <option>Alat Seduh</option>
                <option>Mesin</option>
                <option>Aksesoris</option>
            </select>
            <label>Nama Produk</label>
            <input type="text" name="nama" required>
            <div class="form-row">
                <div>
                    <label>Harga</label>
                    <input type="number" name="harga" min="0" required>
                </div>
                <div>
                    <label>Stok</label>
                    <input type="number" name="stok" min="0" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Satuan</label>
                    <input type="text" name="satuan" required>
                </div>
            </div>
            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>
            <label>Foto</label><br>
            <input type="file" name="foto" id="fotoInput" accept="image/*">
            <div id="fotoPreview"></div>
            <button type="submit" class="btn">Tambah Produk</button>
        </form>
        <?php if (!empty($produk_baru)): ?>
        <div class="produk-list">
            <h3>Produk Ditambahkan:</h3>
            <?php foreach ($produk_baru as $p): ?>
                <div class="produk-item">
                    <?php if ($p['img']): ?><img src="<?= $p['img'] ?>" class="preview-img"><?php endif; ?>
                    <div class="produk-info">
                        <div class="produk-nama"><?= htmlspecialchars($p['nama']) ?></div>
                        <div class="produk-kat">Kategori: <?= htmlspecialchars($p['kategori']) ?></div>
                        <div class="produk-harga">Harga: Rp <?= number_format($p['harga'],0,',','.') ?> | Stok: <?= htmlspecialchars($p['stok']) ?> <?= htmlspecialchars($p['satuan']) ?></div>
                        <div style="font-size:13px;color:#666;">Deskripsi: <?= htmlspecialchars($p['deskripsi']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <script>
    // Preview gambar sebelum upload
    document.getElementById('fotoInput').onchange = function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('fotoPreview').innerHTML = `<img src='${ev.target.result}' class='preview-img' />`;
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            document.getElementById('fotoPreview').innerHTML = '';
        }
    };
    </script>
</body>
</html> 