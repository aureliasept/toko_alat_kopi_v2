<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Alat Kopi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeInUp 0.7s cubic-bezier(.39,.575,.565,1.000);
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .logo p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #ffe6e6;
            color: #d63031;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 15px;
            border-left: 4px solid #d63031;
            text-align: left;
            word-break: break-word;
        }

        .coffee-icon {
            font-size: 40px;
            margin-bottom: 10px;
            color: #764ba2;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .logo h1 {
                font-size: 24px;
            }
            .error-message {
                font-size: 13px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="coffee-icon">☕</div>
            <h1>Toko Alat Kopi</h1>
            <p>Silakan login untuk melanjutkan</p>
        </div>
        <?php
        // Tampilkan pesan error jika ada
        if(isset($_GET['error'])) {
            echo "<div class='error-message' id='error-message'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>
        <!-- Form login -->
        <form method="POST" action="login_process.php" id="loginForm" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required style="padding-right:40px;">
                    <span id="togglePassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;font-size:18px;color:#764ba2;user-select:none;">👁️</span>
                </div>
            </div>
            <button type="submit" class="login-btn" id="loginBtn">Login</button>
        </form>
        <script>
        // Show/hide password
        document.getElementById('togglePassword').onclick = function() {
            var pwd = document.getElementById('password');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                this.textContent = '🙈';
            } else {
                pwd.type = 'password';
                this.textContent = '👁️';
            }
        };
        // Animasi loading pada tombol login
        document.getElementById('loginForm').onsubmit = function() {
            var btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.textContent = 'Loading...';
        };
        </script>
    </div>
</body>
</html>
