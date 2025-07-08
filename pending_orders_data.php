<?php
header('Content-Type: application/json');
$namaList = ['Andi', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hadi'];
$produkList = [
    'Syphon Coffee Maker',
    'Electric Coffee Grinder',
    'French Press',
    'Vietnam Drip',
    'V60 Dripper',
    'Coffee Server',
    'Milk Frother',
    'Espresso Maker'
];
$pending = [];
for ($i = 0; $i < 8; $i++) {
    $pending[] = [
        'nama' => $namaList[$i],
        'produk' => $produkList[array_rand($produkList)],
        'jumlah' => rand(1, 5),
        'status' => 'Pending'
    ];
}
echo json_encode($pending); 