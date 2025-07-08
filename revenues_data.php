<?php
header('Content-Type: application/json');
$revenues = [];
$tanggal_awal = strtotime('2025-07-01');
for ($i = 0; $i < 20; $i++) {
    $tanggal = date('Y-m-d', strtotime("+{$i} days", $tanggal_awal));
    $nominal = rand(200000, 1500000); // Nominal acak antara 200rb - 1,5jt
    $keterangan = ($i % 3 == 0) ? 'Penjualan Online' : (($i % 3 == 1) ? 'Penjualan Offline' : 'Penjualan Grosir');
    $revenues[] = [
        'tanggal' => $tanggal,
        'nominal' => $nominal,
        'keterangan' => $keterangan
    ];
}
echo json_encode($revenues); 