<?php
session_start();
require_once 'config/db.php';

// Ambil data dari form login
default:
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($username === '' || $password === '') {
    header('Location: login.php?error=Username dan password wajib diisi');
    exit();
}
// Query untuk mencari user berdasarkan username (prepared statement)
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        sleep(1); // Delay untuk keamanan
        header('Location: login.php?error=Password salah');
        exit();
    }
} else {
    sleep(1); // Delay untuk keamanan
    header('Location: login.php?error=User tidak ditemukan');
    exit();
}
?>