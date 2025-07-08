<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$produk_file = 'produk_dummy.json';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_dashboard'])) {
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
    $produk_json = file_exists($produk_file) ? json_decode(file_get_contents($produk_file), true) : [];
    $produk_json[] = [
        'nama' => $nama,
        'kategori' => $kategori,
        'harga' => $harga,
        'stok' => $stok,
        'satuan' => $satuan,
        'deskripsi' => $deskripsi,
        'img' => $img
    ];
    file_put_contents($produk_file, json_encode($produk_json, JSON_PRETTY_PRINT));
    header('Location: products_page.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: #f7f8fd; margin:0; }
        .container { max-width: 420px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(106,90,205,0.10); padding: 32px 18px; }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 18px; }
        label { font-weight: 500; color: #333; margin-bottom: 4px; display: block; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px; background: #f8f9fa; margin-bottom: 12px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #6a5acd; background: #fff; box-shadow: 0 0 0 2px rgba(106,90,205,0.08); }
        button { width: 100%; padding: 12px 0; background: linear-gradient(90deg,#6a5acd,#7b2ff2); color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 8px; }
        .back-link { display:block;text-align:center;margin-top:18px;color:#6a5acd;text-decoration:none;font-weight:500; }
        .back-link:hover { text-decoration:underline; }
        #fotoPreviewDashboard img { width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #d1c4e9;margin-bottom:10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Produk</h2>
        <form method="POST" enctype="multipart/form-data" id="formTambahDashboard">
            <input type="hidden" name="tambah_dashboard" value="1">
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
            <div style="display:flex;gap:10px;">
                <div style="flex:1;">
                    <label>Harga</label>
                    <input type="number" name="harga" min="0" required>
                </div>
                <div style="flex:1;">
                    <label>Stok</label>
                    <input type="number" name="stok" min="0" required>
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <div style="flex:1;">
                    <label>Satuan</label>
                    <input type="text" name="satuan" required>
                </div>
            </div>
            <label>Deskripsi</label>
            <textarea name="deskripsi" required style="resize:vertical;"></textarea>
            <label>Foto</label><br>
            <input type="file" name="foto" id="fotoInputDashboard" accept="image/*">
            <div id="fotoPreviewDashboard"></div>
            <button type="submit">Tambah Produk</button>
        </form>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
    <script>
    document.getElementById('fotoInputDashboard').onchange = function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('fotoPreviewDashboard').innerHTML = `<img src='${ev.target.result}' />`;
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            document.getElementById('fotoPreviewDashboard').innerHTML = '';
        }
    };
    </script>
</body>
</html> 