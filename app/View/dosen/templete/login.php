<?php
// Halaman login (login.php)
session_start();

// Simulasi proses login
// Username diambil dari form login (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];  // Ganti ini dengan validasi yang sesuai
    $_SESSION['username'] = $username;  // Simpan username ke session
    header('Location: dashboardmhs.php');  // Redirect ke halaman dashboard
    exit();
}
?>
