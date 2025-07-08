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
$orderNames = ['Customer 1','Customer 2','Customer 3','Customer 4','Customer 5','Customer 6','Customer 7','Customer 8','Customer 9','Customer 10','Customer 11','Customer 12','Customer 13','Customer 14','Customer 15','Customer 16','Customer 17','Customer 18','Customer 19','Customer 20','Customer 21','Customer 22','Customer 23','Customer 24','Customer 25','Customer 26','Customer 27','Customer 28','Customer 29','Customer 30','Customer 31','Customer 32','Customer 33','Customer 34','Customer 35','Customer 36','Customer 37','Customer 38','Customer 39','Customer 40','Customer 41','Customer 42','Customer 43','Customer 44','Customer 45'];
$productList = array_keys($productPrices);
$statusList = ['Completed', 'Processing', 'Pending'];
$orders = [];
for ($i = 0; $i < 45; $i++) {
    $product = $productList[$i % count($productList)];
    $quantity = rand(1, 5);
    $unitPrice = $productPrices[$product];
    $orders[] = [
        'name' => $orderNames[$i],
        'product' => $product,
        'quantity' => $quantity,
        'status' => $statusList[$i % count($statusList)],
        'unit_price' => $unitPrice,
        'total_price' => $unitPrice * $quantity
    ];
}
echo json_encode($orders); 