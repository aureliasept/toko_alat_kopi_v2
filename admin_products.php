<?php
session_start();
// Dummy data produk
$products = [
    [
        'name' => 'Syphon Coffee Maker Manual Brew Vacuum Pot',
        'img' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=400&q=80',
        'stock' => 5,
        'price' => 288000
    ],
    [
        'name' => 'Electric Coffee Grinder - 600N',
        'img' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80',
        'stock' => 17,
        'price' => 500000
    ],
    [
        'name' => 'coffee server / coffee pot 01 / teko server kopi v60',
        'img' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
        'stock' => 18,
        'price' => 47500
    ],
    [
        'name' => 'Vietnam Drip Alat Pembuat Kopi Vietnam',
        'img' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80',
        'stock' => 18,
        'price' => 22000
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
        .layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.04);
            padding: 30px 0 0 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .sidebar .sidebar-title {
            font-size: 20px;
            font-weight: 700;
            color: #764ba2;
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            color: #333;
            text-decoration: none;
            font-size: 15px;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            color: #667eea;
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 28px 40px 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom-left-radius: 20px;
        }
        .header-title {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .search-box {
            background: #fff;
            border-radius: 8px;
            padding: 8px 16px;
            border: none;
            font-size: 15px;
            width: 260px;
            margin-right: 10px;
            box-shadow: 0 2px 8px rgba(102,126,234,0.08);
        }
        .add-btn {
            background: #fff;
            color: #764ba2;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(102,126,234,0.08);
            transition: background 0.2s, color 0.2s;
        }
        .add-btn:hover {
            background: #764ba2;
            color: #fff;
        }
        .content {
            padding: 30px 40px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }
        .product-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(102,126,234,0.08);
            padding: 18px 16px 16px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .product-card:hover {
            box-shadow: 0 8px 32px rgba(102,126,234,0.16);
            transform: translateY(-3px) scale(1.02);
        }
        .product-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 14px;
            background: #f5f5f5;
        }
        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 8px;
            min-height: 40px;
        }
        .product-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .product-price {
            font-size: 15px;
            color: #764ba2;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .product-actions {
            display: flex;
            gap: 8px;
        }
        .action-btn {
            background: #f0f4ff;
            color: #667eea;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .action-btn:hover {
            background: #667eea;
            color: #fff;
        }
        @media (max-width: 900px) {
            .sidebar { width: 60px; padding: 20px 0 0 0; }
            .sidebar .sidebar-title { display: none; }
            .sidebar a span { display: none; }
            .sidebar a { justify-content: center; padding: 12px 0; }
            .header, .content { padding-left: 20px; padding-right: 20px; }
        }
        @media (max-width: 600px) {
            .header, .content { padding-left: 8px; padding-right: 8px; }
            .products-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="layout">
    <nav class="sidebar">
        <div class="sidebar-title">☕ Toko Kopi</div>
        <a href="#" class="active">&#128230; <span>Produk</span></a>
        <a href="#">&#128179; <span>Pesanan</span></a>
        <a href="#">&#128100; <span>Pelanggan</span></a>
        <a href="#">&#128202; <span>Laporan</span></a>
        <a href="#">&#9881; <span>Pengaturan</span></a>
        <a href="logout.php">&#128682; <span>Logout</span></a>
    </nav>
    <div class="main">
        <div class="header">
            <div class="header-title">Kelola Produk</div>
            <div class="header-actions">
                <input type="text" class="search-box" placeholder="Cari produk...">
                <button class="add-btn">Tambah</button>
            </div>
        </div>
        <div class="content">
            <div class="products-grid">
                <?php foreach($products as $p): ?>
                <div class="product-card">
                    <img src="<?php echo $p['img']; ?>" class="product-img" alt="<?php echo htmlspecialchars($p['name']); ?>">
                    <div class="product-name"><?php echo $p['name']; ?></div>
                    <div class="product-info">Stok: <?php echo $p['stock']; ?></div>
                    <div class="product-price">Rp <?php echo number_format($p['price'],0,',','.'); ?></div>
                    <div class="product-actions">
                        <button class="action-btn">Detail</button>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn">Hapus</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html> 