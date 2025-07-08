<?php
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Dummy data (bisa ganti dengan query dari DB)
$totalProducts = 20;
// Ambil data pesanan dari orders_data.php
$ordersData = json_decode(file_get_contents('orders_data.php'), true);
$totalOrders = is_array($ordersData) ? count($ordersData) : 0;
$totalRevenue = 2500000;
$pendingOrders = 8;
// Data produk asli dari admin_products.php
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
// Jika produk kurang dari 20, duplikat agar tetap 20
while(count($products) < 20) {
    foreach($products as $p) {
        if(count($products) >= 20) break;
        $products[] = $p;
    }
}

// Hapus data dummy $orders, $revenues, dan $pendingOrders

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Toko Alat Kopi</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f1f3f8;
        }

        .navbar {
            background: #6a5acd;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-left {
            font-weight: bold;
            font-size: 18px;
        }

        .navbar-right a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .container {
            padding: 40px;
        }

        .welcome {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .welcome h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .card {
            flex: 1;
            min-width: 200px;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            text-align: center;
        }

        .card-icon {
            font-size: 35px;
            margin-bottom: 10px;
        }

        .card-number {
            font-size: 28px;
            font-weight: bold;
            color: #6a5acd;
        }

        .card-label {
            font-size: 14px;
            color: #555;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .card-link:focus .card, .card-link:hover .card {
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.25);
            transform: translateY(-5px) scale(1.03);
            background: #f0f4ff;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-left">☕ Toko Alat Kopi - Admin Dashboard</div>
        <div class="navbar-right">
            <a href="dashboard.php">Dashboard</a>
            <a href="#">Produk</a>
            <a href="#">Pesanan</a>
            <a href="#">Laporan</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Selamat Datang di Dashboard Admin</h2>
            <p>Kelola toko alat kopi Anda dengan mudah dan efisien</p>
        </div>

        <div class="stats">
            <a href="total_produk.php" class="card-link">
                <div class="card">
                    <div class="card-icon">📦</div>
                    <div class="card-number"><?php echo $totalProducts; ?></div>
                    <div class="card-label">Total Produk</div>
                    <ul style="list-style:none;padding:0;margin:15px 0 0 0;max-height:300px;overflow-y:auto;">
                        <?php foreach(array_slice($products,0,20) as $p): ?>
                            <li style="display:flex;align-items:center;margin-bottom:8px;">
                                <img src="<?php echo $p['img']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="width:32px;height:32px;object-fit:cover;border-radius:6px;margin-right:10px;background:#eaeaea;">
                                <span style="font-size:14px;color:#333;"> <?php echo htmlspecialchars($p['name']); ?> </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </a>

            <div class="card" id="totalOrdersCard" style="cursor:pointer;">
                <div class="card-icon">🛒</div>
                <div class="card-number"><?php echo $totalOrders; ?></div>
                <div class="card-label">Total Pesanan</div>
            </div>

            <div class="card" id="revenueCard" style="cursor:pointer;">
                <div class="card-icon">💰</div>
                <div class="card-number">Rp <?php echo number_format($totalRevenue, 0, ',', '.'); ?></div>
                <div class="card-label">Pendapatan</div>
            </div>

            <div class="card" id="pendingOrdersCard" style="cursor:pointer;">
                <div class="card-icon">⏳</div>
                <div class="card-number"><?php echo $pendingOrders; ?></div>
                <div class="card-label">Pesanan Pending</div>
            </div>
        </div>
    </div>

    <!-- Modal Pesanan -->
    <div id="ordersModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Daftar Pesanan</h3>
        <button onclick="document.getElementById('ordersModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="ordersTotal" style="font-size:16px;font-weight:bold;color:#4361ee;margin-bottom:10px;"></div>
        <ul id="ordersList" style="list-style:none;padding:0;margin:0;"></ul>
      </div>
    </div>
    <!-- Modal Pendapatan -->
    <div id="revenueModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Detail Pendapatan</h3>
        <button onclick="document.getElementById('revenueModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="revenuesTable"></div>
      </div>
    </div>
    <!-- Modal Pesanan Pending -->
    <div id="pendingOrdersModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);align-items:center;justify-content:center;">
      <div style="background:#fff;padding:30px 20px 20px 20px;border-radius:12px;max-width:400px;width:90vw;max-height:80vh;overflow-y:auto;position:relative;">
        <h3 style="margin-top:0;margin-bottom:15px;font-size:20px;color:#6a5acd;">Pesanan Pending</h3>
        <button onclick="document.getElementById('pendingOrdersModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:18px;background:none;border:none;cursor:pointer;">&times;</button>
        <div id="pendingOrdersTable"></div>
      </div>
    </div>
<script>
// Pesanan
const ordersCard = document.getElementById('totalOrdersCard');
ordersCard.onclick = function() {
  fetch('orders_data.php')
    .then(res => res.json())
    .then(data => {
      // Tampilkan total pesanan
      document.getElementById('ordersTotal').innerText = `Total Pesanan: ${data.length}`;
      // Tampilkan daftar nama pemesan dan jumlah pesanan
      let html = '';
      data.forEach(o => {
        html += `<li style='display:flex;align-items:center;margin-bottom:10px;background:#f4f4f4;padding:10px 8px;border-radius:8px;'>` +
                `<span style='font-weight:600;color:#6a5acd;margin-right:10px;'>${o.nama}</span>` +
                `<span style='color:#333;'>(${o.produk})</span>` +
                `<span style='margin-left:auto;font-size:15px;color:#222;'>Jumlah: <b>${o.jumlah}</b></span>` +
                `</li>`;
      });
      document.getElementById('ordersList').innerHTML = html;
      document.getElementById('ordersModal').style.display = 'flex';
    });
};
// Pendapatan
const revenueCard = document.getElementById('revenueCard');
revenueCard.onclick = function() {
  fetch('revenues_data.php')
    .then(res => res.json())
    .then(data => {
      let html = `<table style='width:100%;font-size:14px;border-collapse:collapse;'>`;
      html += `<thead><tr style='background:#f0f0f8;color:#333;'><th style='padding:6px 4px;text-align:left;'>Tanggal</th><th style='padding:6px 4px;text-align:right;'>Nominal</th><th style='padding:6px 4px;text-align:left;'>Keterangan</th></tr></thead><tbody>`;
      data.forEach(r => {
        html += `<tr><td style='padding:4px 2px;'>${r.tanggal}</td><td style='padding:4px 2px;text-align:right;'>Rp ${Number(r.nominal).toLocaleString('id-ID')}</td><td style='padding:4px 2px;'>${r.keterangan}</td></tr>`;
      });
      html += `</tbody></table>`;
      document.getElementById('revenuesTable').innerHTML = html;
      document.getElementById('revenueModal').style.display = 'flex';
    });
};
// Pesanan Pending
const pendingOrdersCard = document.getElementById('pendingOrdersCard');
pendingOrdersCard.onclick = function() {
  fetch('pending_orders_data.php')
    .then(res => res.json())
    .then(data => {
      let html = `<table style='width:100%;font-size:14px;border-collapse:collapse;'>`;
      html += `<thead><tr style='background:#f0f0f8;color:#333;'><th style='padding:6px 4px;text-align:left;'>Nama</th><th style='padding:6px 4px;text-align:left;'>Produk</th><th style='padding:6px 4px;text-align:center;'>Jumlah</th></tr></thead><tbody>`;
      data.forEach(o => {
        html += `<tr><td style='padding:4px 2px;'>${o.nama}</td><td style='padding:4px 2px;'>${o.produk}</td><td style='padding:4px 2px;text-align:center;'>${o.jumlah}</td></tr>`;
      });
      html += `</tbody></table>`;
      document.getElementById('pendingOrdersTable').innerHTML = html;
      document.getElementById('pendingOrdersModal').style.display = 'flex';
    });
};
</script>
</body>
</html>