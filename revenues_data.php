<?php
header('Content-Type: application/json');
$revenues = [
    ['tanggal' => '2025-07-01', 'nominal' => 500000, 'keterangan' => 'Penjualan Online'],
    ['tanggal' => '2025-07-02', 'nominal' => 750000, 'keterangan' => 'Penjualan Offline'],
    ['tanggal' => '2025-07-03', 'nominal' => 250000, 'keterangan' => 'Penjualan Online'],
    ['tanggal' => '2025-07-04', 'nominal' => 1000000, 'keterangan' => 'Penjualan Grosir'],
];
while(count($revenues) < 20) {
    foreach($revenues as $r) {
        if(count($revenues) >= 20) break;
        $revenues[] = $r;
    }
}
echo json_encode($revenues); 