<?php
session_start();
require_once 'config/db.php';

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mencari user berdasarkan username
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data user
    $user = $result->fetch_assoc();
    
    // Verifikasi password dengan password_verify
    if (password_verify($password, $user['password'])) {
        // Jika password benar, simpan data user di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');  // Redirect ke dashboard admin
    } else {
        // Jika password salah
        header('Location: login.php?error=Password salah');
    }
} else {
    // Jika user tidak ditemukan
    header('Location: login.php?error=User tidak ditemukan');
}
?>