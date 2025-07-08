<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// Ambil data pesanan dari orders_data.php
$orders = [];
$response = @file_get_contents('http://localhost/toko_alat_kopi1/orders_data.php');
if ($response) {
    $orders = json_decode($response, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: #f7f8fd; margin:0; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(106,90,205,0.10); padding: 32px 18px; }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 18px; }
        .orders-list { list-style:none; padding:0; margin:0; }
        .orders-list li { display:flex;align-items:center;margin-bottom:12px;background:#f4f4f4;padding:10px 8px;border-radius:8px; }
        .orders-list li span { font-weight:600;color:#6a5acd;margin-right:10px; }
        .orders-list li .produk { color:#333; font-weight:400; margin-right:10px; }
        .orders-list li .jumlah { margin-left:auto;font-size:15px;color:#222; }
        .back-link { display:block;text-align:center;margin-top:18px;color:#6a5acd;text-decoration:none;font-weight:500; }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pesanan</h2>
        <div style="font-size:15px;font-weight:bold;color:#4361ee;margin-bottom:10px;">Total Pesanan: <?php echo count($orders); ?></div>
        <ul class="orders-list">
            <?php foreach($orders as $o): ?>
            <li>
                <span><?php echo htmlspecialchars($o['nama']); ?></span>
                <span class="produk">(<?php echo htmlspecialchars($o['produk']); ?>)</span>
                <span class="jumlah">Jumlah: <b><?php echo $o['jumlah']; ?></b></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html> 