<?php
header('Content-Type: application/json');
$orders = [
    ['nama' => 'Andi', 'produk' => 'Syphon Coffee Maker', 'jumlah' => 1, 'status' => 'Selesai'],
    ['nama' => 'Budi', 'produk' => 'Electric Coffee Grinder', 'jumlah' => 2, 'status' => 'Diproses'],
    ['nama' => 'Citra', 'produk' => 'French Press', 'jumlah' => 1, 'status' => 'Selesai'],
    ['nama' => 'Dewi', 'produk' => 'Vietnam Drip', 'jumlah' => 3, 'status' => 'Pending'],
    ['nama' => 'Eka', 'produk' => 'V60 Dripper', 'jumlah' => 1, 'status' => 'Selesai'],
    // ... duplikat hingga 45 ...
];
while(count($orders) < 45) {
    foreach($orders as $o) {
        if(count($orders) >= 45) break;
        $orders[] = $o;
    }
}
echo json_encode($orders); 