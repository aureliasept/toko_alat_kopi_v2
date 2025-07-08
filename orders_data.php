<?php
header('Content-Type: application/json');

$produkList = [
    'Syphon Coffee Maker',
    'Electric Coffee Grinder',
    'French Press',
    'Vietnam Drip',
    'V60 Dripper',
    'Coffee Server',
    'Milk Frother',
    'Espresso Maker',
    'Teko Leher Angsa',
    'Digital Scale',
    'Tamper Kopi',
    'Manual Coffee Grinder',
    'Knock Box',
    'Coffee Bean Storage',
    'Cold Brew Maker',
    'Cleaning Brush',
    'Espresso Shot Glass',
    'Barista Apron',
    'Kapas Kertas Filter',
    'Drip Tray'
];
$statusList = ['Selesai', 'Diproses', 'Pending'];
$orders = [];
for ($i = 1; $i <= 45; $i++) {
    $orders[] = [
        'nama' => 'Pelanggan ' . $i,
        'produk' => $produkList[($i-1) % count($produkList)],
        'jumlah' => rand(1, 5),
        'status' => $statusList[$i % count($statusList)]
    ];
}
echo json_encode($orders); 