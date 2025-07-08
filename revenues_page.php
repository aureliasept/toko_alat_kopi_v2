<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
// Ambil data revenue dari revenues_data.php
$revenues = [];
$response = @file_get_contents('http://localhost/toko_alat_kopi1/revenues_data.php');
if ($response) {
    $revenues = json_decode($response, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pendapatan - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: #f7f8fd; margin:0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(106,90,205,0.10); padding: 32px 18px; }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 18px; }
        table { width: 100%; font-size: 15px; border-collapse: collapse; margin-bottom: 0; }
        thead tr { background: #f3f2fa; }
        th, td { padding: 10px 8px; text-align: left; }
        th { font-weight: 700; color: #5f4bb6; font-size: 15px; border-bottom: 2px solid #e0e0f0; }
        td { border-bottom: 1px solid #f0f0f8; font-size: 15px; }
        tr:nth-child(even) { background: #faf9fd; }
        td:nth-child(2), th:nth-child(2) { text-align: right; font-weight: bold; color: #6a5acd; }
        td:last-child, th:last-child { text-align: left; }
        .back-link { display:block;text-align:center;margin-top:18px;color:#6a5acd;text-decoration:none;font-weight:500; }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Pendapatan</h2>
        <table>
            <thead>
                <tr><th>Tanggal</th><th>Nominal</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
                <?php if (empty($revenues)): ?>
                    <tr><td colspan="3" style="text-align:center;color:#888;">Tidak ada data pendapatan.</td></tr>
                <?php else: ?>
                    <?php foreach($revenues as $r): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($r['tanggal']); ?></td>
                            <td>Rp <?php echo number_format($r['nominal'],0,',','.'); ?></td>
                            <td><?php echo htmlspecialchars($r['keterangan']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html> 