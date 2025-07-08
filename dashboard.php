<?php
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Dummy data (bisa ganti dengan query dari DB)
$totalProducts = 20;
// Ambil data pesanan dari orders_data.php via cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'http://localhost/toko_alat_kopi1/orders_data.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
]);
$response = curl_exec($curl);
curl_close($curl);
$ordersData = json_decode($response, true);
$totalOrders = is_array($ordersData) ? count($ordersData) : 0;
$totalRevenue = 2500000;
$pendingOrders = 8;

// Tambah produk dari form dashboard
$produk_file = 'produk_dummy.json';
$default_products = [
    [ 'name' => 'Syphon Coffee Maker Manual Brew Vacuum Pot', 'img' => 'https://picsum.photos/seed/coffee1/400' ],
    [ 'name' => 'Electric Coffee Grinder - 600N', 'img' => 'https://picsum.photos/seed/coffee2/400' ],
    [ 'name' => 'Coffee Server / Coffee Pot 01 / Teko Server Kopi V60', 'img' => 'https://picsum.photos/seed/coffee3/400' ],
    [ 'name' => 'Vietnam Drip Alat Pembuat Kopi Vietnam', 'img' => 'https://picsum.photos/seed/coffee4/400' ],
    [ 'name' => 'V60 Dripper Plastik Transparan', 'img' => 'https://picsum.photos/seed/coffee5/400' ],
    [ 'name' => 'French Press Pembuat Kopi 600ml', 'img' => 'https://picsum.photos/seed/coffee6/400' ],
    [ 'name' => 'Digital Scale Timbangan Kopi dengan Timer', 'img' => 'https://picsum.photos/seed/coffee7/400' ],
    [ 'name' => 'Tamper Kopi Stainless Steel 58mm', 'img' => 'https://picsum.photos/seed/coffee8/400' ],
    [ 'name' => 'Manual Coffee Grinder Kayu Vintage', 'img' => 'https://picsum.photos/seed/coffee9/400' ],
    [ 'name' => 'Milk Frother Elektrik Pembuat Foam Susu', 'img' => 'https://picsum.photos/seed/coffee10/400' ],
    [ 'name' => 'Espresso Maker Stovetop Moka Pot', 'img' => 'https://picsum.photos/seed/coffee11/400' ],
    [ 'name' => 'Teko Leher Angsa Stainless Pour Over', 'img' => 'https://picsum.photos/seed/coffee12/400' ],
    [ 'name' => 'Drip Tray Alas Cangkir Espresso', 'img' => 'https://picsum.photos/seed/coffee13/400' ],
    [ 'name' => 'Knock Box Tempat Ampas Kopi', 'img' => 'https://picsum.photos/seed/coffee14/400' ],
    [ 'name' => 'Coffee Bean Storage Canister', 'img' => 'https://picsum.photos/seed/coffee15/400' ],
    [ 'name' => 'Cold Brew Coffee Maker 1 Liter', 'img' => 'https://picsum.photos/seed/coffee16/400' ],
    [ 'name' => 'Cleaning Brush Alat Pembersih Mesin Kopi', 'img' => 'https://picsum.photos/seed/coffee17/400' ],
    [ 'name' => 'Espresso Shot Glass 60ml', 'img' => 'https://picsum.photos/seed/coffee18/400' ],
    [ 'name' => 'Barista Apron dengan Saku Kulit', 'img' => 'https://picsum.photos/seed/coffee19/400' ],
    [ 'name' => 'Kapas Kertas Filter V60 (Isi 100)', 'img' => 'https://picsum.photos/seed/coffee20/400' ],
];
// Proses tambah produk jika ada POST
$produk_json = [];
if (file_exists($produk_file)) {
    $produk_json = json_decode(file_get_contents($produk_file), true) ?: [];
}
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
    // Redirect agar tidak resubmit saat refresh
    header('Location: dashboard.php');
    exit();
}
$products = $default_products;
if (!empty($produk_json)) {
    foreach ($produk_json as $p) {
        $products[] = [
            'name' => $p['nama'],
            'img' => $p['img'] ?: 'https://picsum.photos/seed/coffee' . rand(1,100) . '/400',
            'stock' => $p['stok'],
            'price' => $p['harga']
        ];
    }
}
$totalProducts = count($products);

// Hapus data dummy $orders, $revenues, dan $pendingOrders

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f1f3f8 60%, #e0e7ff 100%);
        }
        .navbar {
            background: linear-gradient(90deg, #6a5acd 60%, #7b2ff2 100%);
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 18px rgba(106,90,205,0.10);
        }
        .navbar-left {
            font-weight: bold;
            font-size: 22px;
            letter-spacing: 1px;
        }
        .navbar-right a {
            color: white;
            margin-left: 28px;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.2s;
        }
        .navbar-right a:hover {
            color: #ffe082;
        }
        .container {
            padding: 50px 0 0 0;
            max-width: 1200px;
            margin: 0 auto;
        }
        .welcome {
            background: white;
            border-radius: 18px;
            padding: 38px 30px 30px 30px;
            margin-bottom: 38px;
            text-align: center;
            box-shadow: 0 6px 24px rgba(106,90,205,0.10);
        }
        .welcome h2 {
            margin-bottom: 10px;
            color: #333;
            font-size: 2rem;
            font-weight: 700;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: space-between;
        }
        .card {
            flex: 1;
            min-width: 150px;
            max-width: 180px;
            background: white;
            border-radius: 13px;
            padding: 18px 10px 16px 10px;
            box-shadow: 0 4px 16px rgba(106,90,205,0.10);
            text-align: center;
            transition: box-shadow 0.18s, transform 0.18s, background 0.18s;
            cursor: pointer;
            margin: 0 auto;
        }
        .card:hover {
            box-shadow: 0 10px 28px rgba(123,47,242,0.13);
            transform: translateY(-4px) scale(1.04);
            background: #f7f8fd;
        }
        .card-icon {
            font-size: 28px;
            margin-bottom: 7px;
        }
        .card-number {
            font-size: 22px;
            font-weight: bold;
            color: #6a5acd;
        }
        .card-label {
            font-size: 13px;
            color: #555;
            margin-top: 2px;
        }
        @media (max-width: 900px) {
            .stats { flex-direction: column; gap: 12px; }
            .card { max-width: 100%; min-width: 0; }
        }
        /* Modal styling */
        #ordersModal, #productsModal, #revenueModal, #pendingOrdersModal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            background: rgba(60, 60, 90, 0.18);
            backdrop-filter: blur(2px);
            align-items: center;
            justify-content: center;
            animation: fadeInBg 0.3s;
        }
        @keyframes fadeInBg {
            from { background: rgba(60,60,90,0); }
            to { background: rgba(60,60,90,0.18); }
        }
        #ordersModal > div, #productsModal > div, #revenueModal > div, #pendingOrdersModal > div {
            background: #fff;
            padding: 32px 20px 20px 20px;
            border-radius: 16px;
            max-width: 420px;
            width: 92vw;
            max-height: 82vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 8px 32px rgba(123,47,242,0.13);
            animation: popIn 0.25s;
        }
        @keyframes popIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 22px;
            color: #6a5acd;
            font-weight: 700;
        }
        button[onclick*='Modal'] {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6a5acd;
            transition: color 0.2s;
        }
        button[onclick*='Modal']:hover {
            color: #7b2ff2;
        }
        /* List in modal */
        #ordersList li, #productsList li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            background: #f4f4f4;
            padding: 10px 8px;
            border-radius: 8px;
            font-size: 15px;
        }
        #ordersList li span:first-child, #productsList li span, #productsList li img {
            font-weight: 600;
            color: #6a5acd;
        }
        #ordersList li span {
            margin-right: 10px;
        }
        #ordersList li span:last-child {
            margin-left: auto;
            color: #222;
        }
        #productsList li img {
            width: 32px; height: 32px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 10px;
            background: #eaeaea;
        }
        /* Table in modal */
        table {
            width: 100%;
            font-size: 15px;
            border-collapse: collapse;
        }
        thead tr {
            background: #f0f0f8;
            color: #333;
        }
        th, td {
            padding: 7px 4px;
            text-align: left;
        }
        th {
            font-weight: 600;
        }
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            background: #f0f0f8;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1c4e9;
            border-radius: 6px;
        }
        /* Modal Detail Pesanan */
        #detailOrdersModal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            background: rgba(60, 60, 90, 0.18);
            backdrop-filter: blur(2px);
            align-items: center;
            justify-content: center;
            animation: fadeInBg 0.3s;
        }
        #detailOrdersModal > div {
            background: #fff;
            padding: 32px 20px 20px 20px;
            border-radius: 16px;
            max-width: 700px;
            width: 98vw;
            max-height: 82vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 8px 32px rgba(123,47,242,0.13);
            animation: popIn 0.25s;
        }
        #detailOrdersModal h3 {
            text-align: center;
            color: #6a5acd;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 18px;
            margin-top: 0;
            letter-spacing: 0.5px;
        }
        #detailOrdersTable table {
            width: 100%;
            font-size: 15px;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        #detailOrdersTable thead tr {
            background: #f3f2fa;
        }
        #detailOrdersTable th, #detailOrdersTable td {
            padding: 10px 8px;
            text-align: left;
        }
        #detailOrdersTable th {
            font-weight: 700;
            color: #5f4bb6;
            font-size: 15px;
            border-bottom: 2px solid #e0e0f0;
        }
        #detailOrdersTable td {
            border-bottom: 1px solid #f0f0f8;
            font-size: 15px;
        }
        #detailOrdersTable tr:nth-child(even) {
            background: #faf9fd;
        }
        #detailOrdersTable td:nth-child(1),
        #detailOrdersTable th:nth-child(1) {
            text-align: center;
            width: 36px;
        }
        #detailOrdersTable td:nth-child(4),
        #detailOrdersTable th:nth-child(4),
        #detailOrdersTable td:nth-child(5),
        #detailOrdersTable th:nth-child(5),
        #detailOrdersTable td:nth-child(6),
        #detailOrdersTable th:nth-child(6) {
            text-align: right;
        }
        #detailOrdersTable td:nth-child(6) {
            font-weight: bold;
            color: #6a5acd;
        }
        #detailOrdersTable td:last-child, #detailOrdersTable th:last-child {
            text-align: center;
        }
        @media (max-width: 600px) {
            #detailOrdersModal > div { padding: 18px 2vw 12px 2vw; }
            #detailOrdersTable th, #detailOrdersTable td { padding: 7px 2px; font-size: 13px; }
            #detailOrdersModal h3 { font-size: 18px; }
        }
        #revenueModal > div {
            background: #fff;
            padding: 32px 20px 20px 20px;
            border-radius: 16px;
            max-width: 600px;
            width: 96vw;
            max-height: 82vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 8px 32px rgba(123,47,242,0.13);
            animation: popIn 0.25s;
        }
        #revenueModal h3 {
            text-align: center;
            color: #6a5acd;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 18px;
            margin-top: 0;
            letter-spacing: 0.5px;
        }
        #revenuesTable table {
            width: 100%;
            font-size: 15px;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        #revenuesTable thead tr {
            background: #f3f2fa;
        }
        #revenuesTable th, #revenuesTable td {
            padding: 10px 8px;
            text-align: left;
        }
        #revenuesTable th {
            font-weight: 700;
            color: #5f4bb6;
            font-size: 15px;
            border-bottom: 2px solid #e0e0f0;
        }
        #revenuesTable td {
            border-bottom: 1px solid #f0f0f8;
            font-size: 15px;
        }
        #revenuesTable tr:nth-child(even) {
            background: #faf9fd;
        }
        #revenuesTable td:nth-child(2), #revenuesTable th:nth-child(2) {
            text-align: right;
            font-weight: bold;
            color: #6a5acd;
        }
        #revenuesTable td:last-child, #revenuesTable th:last-child {
            text-align: left;
        }
        @media (max-width: 600px) {
            #revenueModal > div { padding: 18px 2vw 12px 2vw; }
            #revenuesTable th, #revenuesTable td { padding: 7px 2px; font-size: 13px; }
            #revenueModal h3 { font-size: 18px; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-left">☕ Toko Alat Kopi - Admin Dashboard</div>
        <div class="navbar-right">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profil</a>
            <a href="logout.php" id="logoutLink">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Selamat Datang di Dashboard Admin</h2>
            <p>Kelola toko alat kopi Anda dengan mudah dan efisien</p>
        </div>
        <div class="stats">
            <a href="products_page.php" class="card" id="totalProductsCard">
                <div class="card-icon">📦</div>
                <div class="card-number"><?php echo $totalProducts; ?></div>
                <div class="card-label">Total Produk</div>
            </a>
            <a href="add_product_page.php" class="card" id="addProductCard">
                <div class="card-icon">➕</div>
                <div class="card-number" style="color:#6a5acd;font-size:28px;font-weight:bold;">Tambah</div>
                <div class="card-label">Tambah Produk</div>
            </a>
            <a href="orders_page.php" class="card" id="totalOrdersCard">
                <div class="card-icon">🛒</div>
                <div class="card-number"><?php echo $totalOrders; ?></div>
                <div class="card-label">Total Pesanan</div>
            </a>
            <a href="detail_orders_page.php" class="card" id="detailOrdersCard">
                <div class="card-icon">📄</div>
                <div class="card-number" style="color:#6a5acd;font-size:28px;font-weight:bold;">Detail</div>
                <div class="card-label">Detail Pesanan</div>
            </a>
            <a href="invoice.php" class="card" id="invoiceCard" target="_blank">
                <div class="card-icon">🧾</div>
                <div class="card-number" style="color:#6a5acd;font-size:28px;font-weight:bold;">Invoice</div>
                <div class="card-label">Invoice</div>
            </a>
            <a href="revenues_page.php" class="card" id="revenueCard">
                <div class="card-icon">💰</div>
                <div class="card-number">Rp <?php echo number_format($totalRevenue, 0, ',', '.'); ?></div>
                <div class="card-label">Pendapatan</div>
            </a>
            <a href="pending_orders_page.php" class="card" id="pendingOrdersCard">
                <div class="card-icon">⏳</div>
                <div class="card-number"><?php echo $pendingOrders; ?></div>
                <div class="card-label">Pesanan Pending</div>
            </a>
        </div>
        <!-- Modal Tambah Produk -->
        <div id="addProductModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(60,60,90,0.18);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
          <div style="background:#fff;padding:32px 20px 20px 20px;border-radius:16px;max-width:420px;width:92vw;max-height:82vh;overflow-y:auto;position:relative;box-shadow:0 8px 32px rgba(123,47,242,0.13);animation:popIn 0.25s;">
            <h3 style="margin-top:0;margin-bottom:15px;font-size:22px;color:#6a5acd;font-weight:700;">Tambah Produk</h3>
            <button onclick="document.getElementById('addProductModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:20px;background:none;border:none;cursor:pointer;color:#6a5acd;">&times;</button>
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
                <button type="submit" style="width:100%;padding:12px 0;background:linear-gradient(90deg,#6a5acd,#7b2ff2);color:#fff;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;margin-top:8px;">Tambah Produk</button>
            </form>
          </div>
        </div>
    </div>

    <!-- Modal Pesanan -->
    <div id="ordersModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Daftar Pesanan</h3>
        <button onclick="document.getElementById('ordersModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="ordersTotal" style="font-size:16px;font-weight:bold;color:#4361ee;margin-bottom:10px;"></div>
        <ul id="ordersList" style="list-style:none;padding:0;margin:0;"></ul>
      </div>
    </div>
    <!-- Modal Pendapatan -->
    <div id="revenueModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Detail Pendapatan</h3>
        <button onclick="document.getElementById('revenueModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="revenuesTable"></div>
      </div>
    </div>
    <!-- Modal Pesanan Pending -->
    <div id="pendingOrdersModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Pesanan Pending</h3>
        <button onclick="document.getElementById('pendingOrdersModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="pendingOrdersTable"></div>
      </div>
    </div>
    <!-- Modal Produk -->
    <div id="productsModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Daftar Produk</h3>
        <button onclick="document.getElementById('productsModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="productsTotal" style="font-size:16px;font-weight:bold;color:#4361ee;margin-bottom:10px;">Total Produk: <?php echo $totalProducts; ?></div>
        <ul id="productsList" style="list-style:none;padding:0;margin:0;">
          <?php foreach($products as $p): ?>
            <li style='display:flex;align-items:center;margin-bottom:10px;background:#f4f4f4;padding:10px 8px;border-radius:8px;'>
              <img src="<?php echo $p['img']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="width:32px;height:32px;object-fit:cover;border-radius:6px;margin-right:10px;background:#eaeaea;">
              <span style='font-weight:600;color:#6a5acd;'><?php echo htmlspecialchars($p['name']); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <!-- Modal Detail Pesanan -->
    <div id="detailOrdersModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(60,60,90,0.18);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:32px 20px 20px 20px;border-radius:16px;max-width:600px;width:96vw;max-height:82vh;overflow-y:auto;position:relative;box-shadow:0 8px 32px rgba(123,47,242,0.13);animation:popIn 0.25s;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:22px;color:#6a5acd;font-weight:700;">Detail Seluruh Pesanan</h3>
        <button onclick="document.getElementById('detailOrdersModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:20px;background:none;border:none;cursor:pointer;color:#6a5acd;">&times;</button>
        <div id="detailOrdersTable"></div>
      </div>
    </div>
<!-- Modal Konfirmasi Logout -->
<div id="logoutModal" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100vw;height:100vh;background:rgba(60,60,90,0.18);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
  <div style="background:#fff;padding:32px 24px 24px 24px;border-radius:16px;max-width:340px;width:92vw;box-shadow:0 8px 32px rgba(123,47,242,0.13);text-align:center;animation:popIn 0.25s;position:relative;">
    <h3 style="margin-top:0;margin-bottom:18px;font-size:20px;color:#6a5acd;font-weight:700;">Konfirmasi Logout</h3>
    <div style="font-size:15px;color:#333;margin-bottom:22px;">Yakin ingin logout?</div>
    <button id="confirmLogoutBtn" style="background:linear-gradient(90deg,#6a5acd,#7b2ff2);color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:600;padding:10px 28px;cursor:pointer;margin-right:10px;">Logout</button>
    <button id="cancelLogoutBtn" style="background:#eee;color:#6a5acd;border:none;border-radius:8px;font-size:15px;font-weight:600;padding:10px 22px;cursor:pointer;">Batal</button>
  </div>
</div>
<script>
// Pesanan
const ordersCard = document.getElementById('totalOrdersCard');
ordersCard.onclick = function() {
  fetch('orders_data.php')
    .then(res => res.json())
    .then(data => {
      // Tampilkan total pesanan
      document.getElementById('ordersTotal').innerText = `Total Pesanan: ${data.length}`;
      // Tampilkan daftar nama pemesan dan jumlah pesanan
      let html = '';
      data.forEach(o => {
        html += `<li style='display:flex;align-items:center;margin-bottom:10px;background:#f4f4f4;padding:10px 8px;border-radius:8px;'>` +
                `<span style='font-weight:600;color:#6a5acd;margin-right:10px;'>${o.nama}</span>` +
                `<span style='color:#333;'>(${o.produk})</span>` +
                `<span style='margin-left:auto;font-size:15px;color:#222;'>Jumlah: <b>${o.jumlah}</b></span>` +
                `</li>`;
      });
      document.getElementById('ordersList').innerHTML = html;
      document.getElementById('ordersModal').style.display = 'flex';
    });
};
// Pendapatan
const revenueCard = document.getElementById('revenueCard');
revenueCard.onclick = function() {
  fetch('revenues_data.php')
    .then(res => res.json())
    .then(data => {
      let html = `<table><thead><tr><th>Tanggal</th><th>Nominal</th><th>Keterangan</th></tr></thead><tbody>`;
      data.forEach(r => {
        html += `<tr><td>${r.tanggal}</td><td>Rp ${Number(r.nominal).toLocaleString('id-ID')}</td><td>${r.keterangan}</td></tr>`;
      });
      html += `</tbody></table>`;
      document.getElementById('revenuesTable').innerHTML = html;
      document.getElementById('revenueModal').style.display = 'flex';
    });
};
// Pesanan Pending
const pendingOrdersCard = document.getElementById('pendingOrdersCard');
pendingOrdersCard.onclick = function() {
  fetch('pending_orders_data.php')
    .then(res => res.json())
    .then(data => {
      let html = `<table style='width:100%;font-size:14px;border-collapse:collapse;'>`;
      html += `<thead><tr style='background:#f0f0f8;color:#333;'><th style='padding:6px 4px;text-align:left;'>Nama</th><th style='padding:6px 4px;text-align:left;'>Produk</th><th style='padding:6px 4px;text-align:center;'>Jumlah</th></tr></thead><tbody>`;
      data.forEach(o => {
        html += `<tr><td style='padding:4px 2px;'>${o.nama}</td><td style='padding:4px 2px;'>${o.produk}</td><td style='padding:4px 2px;text-align:center;'>${o.jumlah}</td></tr>`;
      });
      html += `</tbody></table>`;
      document.getElementById('pendingOrdersTable').innerHTML = html;
      document.getElementById('pendingOrdersModal').style.display = 'flex';
    });
};
// Produk
const productsCard = document.getElementById('totalProductsCard');
productsCard.onclick = function() {
  document.getElementById('productsModal').style.display = 'flex';
};
// Detail Orders (English, with total price)
const detailOrdersCard = document.getElementById('detailOrdersCard');
detailOrdersCard.onclick = function() {
  fetch('detail_orders.php')
    .then(res => res.json())
    .then(data => {
      let html = `<table><thead><tr><th>No</th><th>Nama</th><th>Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Total Harga</th><th>Status</th></tr></thead><tbody>`;
      data.forEach((o, i) => {
        html += `<tr><td style='padding:4px 2px;'>${i+1}</td><td style='padding:4px 2px;'>${o.name}</td><td style='padding:4px 2px;'>${o.product}</td><td style='padding:4px 2px;text-align:center;'>${o.quantity}</td><td style='padding:4px 2px;text-align:center;'>Rp ${Number(o.unit_price).toLocaleString('id-ID')}</td><td style='padding:4px 2px;text-align:center;font-weight:bold;color:#6a5acd;'>Rp ${Number(o.total_price).toLocaleString('id-ID')}</td><td style='padding:4px 2px;text-align:center;'>${o.status}</td></tr>`;
      });
      html += `</tbody></table>`;
      document.getElementById('detailOrdersTable').innerHTML = html;
      document.getElementById('detailOrdersModal').style.display = 'flex';
    });
};
document.getElementById('fotoInputDashboard').onchange = function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('fotoPreviewDashboard').innerHTML = `<img src='${ev.target.result}' style='width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #d1c4e9;margin-bottom:10px;' />`;
        };
        reader.readAsDataURL(e.target.files[0]);
    } else {
        document.getElementById('fotoPreviewDashboard').innerHTML = '';
    }
};
// Show/hide modal tambah produk
const addProductCard = document.getElementById('addProductCard');
const addProductModal = document.getElementById('addProductModal');
addProductCard.onclick = function() {
    addProductModal.style.display = 'flex';
};
const invoiceCard = document.getElementById('invoiceCard');
invoiceCard.onclick = function() {
    window.open('invoice.php', '_blank');
};
// Intercept klik Logout
const logoutLink = document.getElementById('logoutLink');
const logoutModal = document.getElementById('logoutModal');
const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');
logoutLink.onclick = function(e) {
  e.preventDefault();
  logoutModal.style.display = 'flex';
};
confirmLogoutBtn.onclick = function() {
  window.location.href = 'logout.php';
};
cancelLogoutBtn.onclick = function() {
  logoutModal.style.display = 'none';
};
// Tutup modal jika klik di luar box
logoutModal.onclick = function(e) {
  if (e.target === logoutModal) logoutModal.style.display = 'none';
};
</script>
</body>
</html>