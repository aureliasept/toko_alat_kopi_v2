<?php
// Dummy data invoice
$customerNames = [
    'Andi', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Intan', 'Joko',
    'Kiki', 'Lina', 'Mira', 'Nina', 'Oki', 'Putri', 'Qori', 'Rian', 'Sari', 'Tono',
    'Umar', 'Vina', 'Wawan', 'Xenia', 'Yani', 'Zaki', 'Bagus', 'Cici', 'Dian', 'Edo',
    'Fani', 'Galih', 'Hana', 'Indra', 'Jihan', 'Kamal', 'Laila', 'Maman', 'Nadia', 'Omar',
    'Pipit', 'Qila', 'Rizky', 'Sinta', 'Tari'
];
$statusList = ['Dibatalkan', 'Selesai', 'Dalam proses'];
$invoices = [];
for ($i = 0; $i < 10; $i++) {
    $inv = '#INV' . date('ymd') . str_pad($i+1, 4, '0', STR_PAD_LEFT);
    $customer = $customerNames[$i % count($customerNames)];
    $date = date('l, d F Y', strtotime("-{$i} days"));
    $itemCount = rand(1, 3);
    $total = rand(20000, 150000) * $itemCount;
    $status = $statusList[$i % count($statusList)];
    $invoices[] = [
        'invoice' => $inv,
        'customer' => $customer,
        'date' => $date,
        'item_count' => $itemCount,
        'total' => $total,
        'status' => $status
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f1f3f8 60%, #e0e7ff 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        thead tr {
            background: #f3f2fa;
        }
        th, td {
            padding: 12px 8px;
            font-size: 15px;
        }
        th {
            font-weight: 700;
            color: #5f4bb6;
            border-bottom: 2px solid #e0e0f0;
        }
        td {
            border-bottom: 1px solid #f0f0f8;
        }
        tr:nth-child(even) {
            background: #faf9fd;
        }
        td:nth-child(1), th:nth-child(1) {
            text-align: center;
            width: 36px;
        }
        td:nth-child(4), th:nth-child(4), td:nth-child(5), th:nth-child(5), td:nth-child(6), th:nth-child(6) {
            text-align: right;
        }
        td:nth-child(6) {
            font-weight: bold;
            color: #6a5acd;
        }
        td:last-child, th:last-child {
            text-align: center;
        }
        .btn-back {
            display: inline-block;
            margin-bottom: 18px;
            background: linear-gradient(90deg,#6a5acd,#7b2ff2);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(106,90,205,0.10);
            transition: background 0.2s;
        }
        .btn-back:hover {
            background: linear-gradient(90deg,#7b2ff2,#6a5acd);
        }
        @media (max-width: 700px) {
            .container { padding: 18px 2vw 12px 2vw; }
            th, td { padding: 7px 2px; font-size: 13px; }
            h2 { font-size: 18px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
        <h2>Kelola Order Customer</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Jumlah Item</th>
                    <th>Jumlah Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $i => $inv): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($inv['invoice']) ?></td>
                    <td><?= htmlspecialchars($inv['customer']) ?></td>
                    <td><?= htmlspecialchars($inv['date']) ?></td>
                    <td><?= $inv['item_count'] ?></td>
                    <td>Rp <?= number_format($inv['total'],0,',','.') ?></td>
                    <td><?= htmlspecialchars($inv['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 