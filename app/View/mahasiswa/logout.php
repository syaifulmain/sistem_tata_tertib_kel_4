<?php
session_start();
session_unset(); // Menghapus semua data session
session_destroy(); // Mengakhiri session
header("Location: ../login/login.php"); // Redirect ke halaman login
exit();
?>