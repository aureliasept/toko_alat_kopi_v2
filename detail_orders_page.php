<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// Ambil data detail orders dari detail_orders.php
$orders = [];
$response = @file_get_contents('http://localhost/toko_alat_kopi1/detail_orders.php');
if ($response) {
    $orders = json_decode($response, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Seluruh Pesanan - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: #f7f8fd; margin:0; }
        .container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(106,90,205,0.10); padding: 32px 18px; }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 18px; }
        table { width: 100%; font-size: 15px; border-collapse: collapse; margin-bottom: 0; }
        thead tr { background: #f3f2fa; }
        th, td { padding: 10px 8px; text-align: left; }
        th { font-weight: 700; color: #5f4bb6; font-size: 15px; border-bottom: 2px solid #e0e0f0; }
        td { border-bottom: 1px solid #f0f0f8; font-size: 15px; }
        tr:nth-child(even) { background: #faf9fd; }
        td:nth-child(1), th:nth-child(1) { text-align: center; width: 36px; }
        td:nth-child(4), th:nth-child(4), td:nth-child(5), th:nth-child(5), td:nth-child(6), th:nth-child(6) { text-align: right; }
        td:nth-child(6) { font-weight: bold; color: #6a5acd; }
        td:last-child, th:last-child { text-align: center; }
        .back-link { display:block;text-align:center;margin-top:18px;color:#6a5acd;text-decoration:none;font-weight:500; }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Seluruh Pesanan</h2>
        <table>
            <thead>
                <tr><th>No</th><th>Nama</th><th>Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Total Harga</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="7" style="text-align:center;color:#888;">Tidak ada data pesanan.</td></tr>
                <?php else: ?>
                    <?php foreach($orders as $i => $o): ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo htmlspecialchars($o['name']); ?></td>
                            <td><?php echo htmlspecialchars($o['product']); ?></td>
                            <td style="text-align:center;"><?php echo $o['quantity']; ?></td>
                            <td style="text-align:center;">Rp <?php echo number_format($o['unit_price'],0,',','.'); ?></td>
                            <td style="text-align:center;font-weight:bold;color:#6a5acd;">Rp <?php echo number_format($o['total_price'],0,',','.'); ?></td>
                            <td style="text-align:center;"><?php echo htmlspecialchars($o['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html> 