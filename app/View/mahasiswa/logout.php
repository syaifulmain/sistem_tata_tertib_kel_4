<?php
session_start();
session_unset(); // Menghapus semua data session
session_destroy(); // Mengakhiri session database
header("Location: ../login/login.php"); // Redirect ke halaman login
exit();
?>