<?php
header('Content-Type: application/json');
// Dummy product prices
$productPrices = [
    'Syphon Coffee Maker' => 50000,
    'Electric Coffee Grinder' => 120000,
    'French Press' => 80000,
    'Vietnam Drip' => 40000,
    'V60 Dripper' => 35000,
    'Coffee Server' => 60000,
    'Milk Frother' => 30000,
    'Espresso Maker' => 150000,
    'Teko Leher Angsa' => 45000,
    'Digital Scale' => 70000,
    'Tamper Kopi' => 25000,
    'Manual Coffee Grinder' => 90000,
    'Knock Box' => 20000,
    'Coffee Bean Storage' => 55000,
    'Cold Brew Maker' => 95000,
    'Cleaning Brush' => 15000,
    'Espresso Shot Glass' => 10000,
    'Barista Apron' => 40000,
    'Kapas Kertas Filter' => 5000,
    'Drip Tray' => 20000
];
$customerNames = [
    'Andi', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Intan', 'Joko',
    'Kiki', 'Lina', 'Mira', 'Nina', 'Oki', 'Putri', 'Qori', 'Rian', 'Sari', 'Tono',
    'Umar', 'Vina', 'Wawan', 'Xenia', 'Yani', 'Zaki', 'Bagus', 'Cici', 'Dian', 'Edo',
    'Fani', 'Galih', 'Hana', 'Indra', 'Jihan', 'Kamal', 'Laila', 'Maman', 'Nadia', 'Omar',
    'Pipit', 'Qila', 'Rizky', 'Sinta', 'Tari'
];
$productList = array_keys($productPrices);
$statusList = ['Selesai', 'Diproses', 'Pending'];
$orders = [];
for ($i = 0; $i < 45; $i++) {
    $product = $productList[$i % count($productList)];
    $quantity = rand(1, 5);
    $unitPrice = $productPrices[$product];
    $orders[] = [
        'name' => $customerNames[$i % count($customerNames)],
        'product' => $product,
        'quantity' => $quantity,
        'status' => $statusList[$i % count($statusList)],
        'unit_price' => $unitPrice,
        'total_price' => $unitPrice * $quantity
    ];
}
echo json_encode($orders); 