<?php
$products = [
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
    [ 'name' => 'Teko Leher Angsa Stainless Pour Over', 'img' => 'https://picsum.photos/seed/coffee12/400' ],
    [ 'name' => 'Drip Tray Alas Cangkir Espresso', 'img' => 'https://picsum.photos/seed/coffee13/400' ],
    [ 'name' => 'Knock Box Tempat Ampas Kopi', 'img' => 'https://picsum.photos/seed/coffee14/400' ],
    [ 'name' => 'Coffee Bean Storage Canister', 'img' => 'https://picsum.photos/seed/coffee15/400' ],
    [ 'name' => 'Cold Brew Coffee Maker 1 Liter', 'img' => 'https://picsum.photos/seed/coffee16/400' ],
    [ 'name' => 'Cleaning Brush Alat Pembersih Mesin Kopi', 'img' => 'https://picsum.photos/seed/coffee17/400' ],
    [ 'name' => 'Espresso Shot Glass 60ml', 'img' => 'https://picsum.photos/seed/coffee18/400' ],
    [ 'name' => 'Barista Apron dengan Saku Kulit', 'img' => 'https://picsum.photos/seed/coffee19/400' ],
    [ 'name' => 'Kapas Kertas Filter V60 (Isi 100)', 'img' => 'https://picsum.photos/seed/coffee20/400' ],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Total Produk</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: start;
            min-height: 100vh;
            padding: 30px 0;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
            max-height: 90vh;
        }

        h2 {
            text-align: center;
            color: #7b2cbf;
            margin-bottom: 5px;
        }

        .count {
            font-size: 48px;
            font-weight: bold;
            color: #4361ee;
            text-align: center;
            margin-bottom: 10px;
        }

        .description {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }

        .product {
            background: #f4f4f4;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product span {
            font-size: 15px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Total Produk</h2>
        <div class="count"><?= count($products) ?></div>
        <div class="description">Produk tersedia di toko:</div>

        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>">
                <span><?= $product['name'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>