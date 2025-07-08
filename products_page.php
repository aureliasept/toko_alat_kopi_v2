<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$produk_file = 'produk_dummy.json';
$default_products = [
    [ 'name' => 'Syphon Coffee Maker Manual Brew Vacuum Pot', 'img' => 'https://picsum.photos/seed/coffee1/400' ],
    [ 'name' => 'Electric Coffee Grinder - 600N', 'img' => 'https://picsum.photos/seed/coffee2/400' ],
    [ 'name' => 'Coffee Server / Coffee Pot 01 / Teko Server Kopi V60', 'img' => 'https://picsum.photos/seed/coffee3/400' ],
    [ 'name' => 'Vietnam Drip Alat Pembuat Kopi Vietnam', 'img' => 'https://picsum.photos/seed/coffee4/400' ],
    [ 'name' => 'V60 Dripper Plastik Transparan', 'img' => 'https://picsum.photos/seed/coffee5/400' ],
    [ 'name' => 'French Press Pembuat Kopi 600ml', 'img' => 'https://picsum.photos/seed/coffee6/400' ],
    [ 'name' => 'Digital Scale Timbangan Kopi dengan Timer', 'img' => 'https://picsum.photos/seed/coffee7/400' ],
    [ 'name' => 'Tamper Kopi Stainless Steel 58mm', 'img' => 'https://picsum.photos/seed/coffee8/400' ],
    [ 'name' => 'Manual Coffee Grinder Kayu Vintage', 'img' => 'https://picsum.photos/seed/coffee9/400' ],
    [ 'name' => 'Milk Frother Elektrik Pembuat Foam Susu', 'img' => 'https://picsum.photos/seed/coffee10/400' ],
    [ 'name' => 'Espresso Maker Stovetop Moka Pot', 'img' => 'https://picsum.photos/seed/coffee11/400' ],
];
$produk_json = [];
if (file_exists($produk_file)) {
    $produk_json = json_decode(file_get_contents($produk_file), true) ?: [];
}
$products = $default_products;
if (!empty($produk_json)) {
    foreach ($produk_json as $p) {
        $products[] = [
            'name' => $p['nama'],
            'img' => $p['img'] ?: 'https://picsum.photos/seed/coffee' . rand(1,100) . '/400',
            'stock' => $p['stok'],
            'price' => $p['harga']
        ];
    }
}
$totalProducts = count($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: #f7f8fd; margin:0; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(106,90,205,0.10); padding: 32px 18px; }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 18px; }
        .products-list { list-style:none; padding:0; margin:0; }
        .products-list li { display:flex;align-items:center;margin-bottom:12px;background:#f4f4f4;padding:10px 8px;border-radius:8px; }
        .products-list li img { width:32px;height:32px;object-fit:cover;border-radius:6px;margin-right:10px;background:#eaeaea; }
        .products-list li span { font-weight:600;color:#6a5acd; }
        .back-link { display:block;text-align:center;margin-top:18px;color:#6a5acd;text-decoration:none;font-weight:500; }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Produk</h2>
        <div style="font-size:15px;font-weight:bold;color:#4361ee;margin-bottom:10px;">Total Produk: <?php echo $totalProducts; ?></div>
        <ul class="products-list">
            <?php foreach($products as $p): ?>
            <li>
                <img src="<?php echo $p['img']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                <span><?php echo htmlspecialchars($p['name']); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html> 