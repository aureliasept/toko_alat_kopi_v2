<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Toko Alat Kopi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .home-container {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .coffee-icon {
            font-size: 48px;
            color: #764ba2;
            margin-bottom: 10px;
        }
        .home-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .home-desc {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .login-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 36px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102,126,234,0.12);
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102,126,234,0.18);
        }
        @media (max-width: 480px) {
            .home-container {
                padding: 30px 10px;
            }
            .home-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="home-container">
        <div class="coffee-icon">☕</div>
        <div class="home-title">Selamat Datang di Toko Alat Kopi</div>
        <div class="home-desc">Temukan berbagai alat kopi terbaik untuk kebutuhan Anda. Silakan login untuk mengelola toko.</div>
        <a href="login.php" class="login-btn">Login</a>
    </div>
</body>
</html>