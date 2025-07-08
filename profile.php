<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($old === '' || $new === '' || $confirm === '') {
        $error = 'Semua field wajib diisi.';
    } elseif ($new !== $confirm) {
        $error = 'Password baru dan konfirmasi tidak sama.';
    } else {
        $stmt = $conn->prepare('SELECT password FROM users WHERE id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($old, $row['password'])) {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $stmt2 = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
                $stmt2->bind_param('si', $hash, $user_id);
                if ($stmt2->execute()) {
                    $message = 'Password berhasil diganti!';
                } else {
                    $error = 'Gagal mengganti password.';
                }
            } else {
                $error = 'Password lama salah.';
            }
        } else {
            $error = 'User tidak ditemukan.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil User - Toko Alat Kopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', 'Segoe UI', sans-serif; background: linear-gradient(135deg, #f1f3f8 60%, #e0e7ff 100%); margin:0; }
        .profile-container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 18px; box-shadow: 0 6px 24px rgba(106,90,205,0.10); padding: 36px 28px; }
        h2 { text-align: center; color: #6a5acd; margin-bottom: 18px; }
        .profile-info { margin-bottom: 30px; }
        .profile-label { color: #555; font-size: 15px; margin-bottom: 4px; }
        .profile-value { font-size: 18px; font-weight: 600; color: #333; }
        .form-group { margin-bottom: 18px; }
        .password-group label { margin-bottom: 6px; display: block; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper input { flex: 1; padding-right: 38px; }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #764ba2;
            user-select: none;
        }
        .form-group label { display: block; margin-bottom: 7px; color: #333; font-weight: 500; font-size: 14px; }
        .form-group input { width: 100%; padding: 11px 13px; border: 2px solid #e1e5e9; border-radius: 9px; font-size: 14px; background: #f8f9fa; transition: all 0.3s; }
        .form-group input:focus { outline: none; border-color: #6a5acd; background: #fff; box-shadow: 0 0 0 2px rgba(106,90,205,0.08); }
        .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 9px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s; margin-top: 8px; }
        .btn:hover { background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); }
        .message { background: #e6ffe6; color: #218838; padding: 12px; border-radius: 8px; margin-bottom: 18px; font-size: 15px; border-left: 4px solid #218838; }
        .error { background: #ffe6e6; color: #d63031; padding: 12px; border-radius: 8px; margin-bottom: 18px; font-size: 15px; border-left: 4px solid #d63031; }
        .back-link { display: block; text-align: center; margin-top: 18px; color: #6a5acd; text-decoration: none; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Profil User</h2>
        <?php if ($message): ?><div class="message"><?php echo $message; ?></div><?php endif; ?>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <div class="profile-info">
            <div class="profile-label">Username:</div>
            <div class="profile-value"><?php echo htmlspecialchars($username); ?></div>
        </div>
        <form method="POST" autocomplete="off">
            <div class="form-group password-group">
                <label for="old_password">Password Lama</label>
                <div class="input-wrapper">
                    <input type="password" id="old_password" name="old_password" required>
                    <span class="toggle-password" onclick="togglePwd('old_password', this)">👁️</span>
                </div>
            </div>
            <div class="form-group password-group">
                <label for="new_password">Password Baru</label>
                <div class="input-wrapper">
                    <input type="password" id="new_password" name="new_password" required>
                    <span class="toggle-password" onclick="togglePwd('new_password', this)">👁️</span>
                </div>
            </div>
            <div class="form-group password-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <div class="input-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <span class="toggle-password" onclick="togglePwd('confirm_password', this)">👁️</span>
                </div>
            </div>
            <button type="submit" class="btn">Ganti Password</button>
        </form>
        <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
    </div>
    <script>
function togglePwd(id, el) {
    var inp = document.getElementById(id);
    if (inp.type === 'password') {
        inp.type = 'text';
        el.textContent = '🙈';
    } else {
        inp.type = 'password';
        el.textContent = '👁️';
    }
}
</script>
</body>
</html> 