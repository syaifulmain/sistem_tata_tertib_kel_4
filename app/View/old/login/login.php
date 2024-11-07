<?php
// Koneksi ke MySQL menggunakan PDO
// try {
//     $conn = new PDO("mysql:host=localhost;dbname=NamaDatabaseAnda", "username", "password");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (Exception $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }

// Proses login saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Username atau Password salah";
        }
    } else {
        $error = "Harus diisi";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Tata Tertib</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS untuk mengatur tampilan halaman */
        body {
            background-color: #2c3e50;
        }
        #loginCard {
            width: 200%;
            max-width: 600px;
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        #logo {
            width: 250px;
            height: auto;
        }
        /* CSS untuk kolom notifikasi merah muda */
        #notification {
            background-color: #f8d7da; /* Warna merah muda */
            color: #721c24; /* Warna teks merah tua */
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        /* Memperbesar ukuran kolom input ke arah vertikal */
        #loginForm .form-control {
            font-size: 1.1rem; /* Perbesar teks dalam kolom input */
            padding: 1rem; /* Perbesar tinggi kolom input dengan padding */
            height: 60px; /* Atur tinggi kolom input */
            width: 100%; /* Atur lebar kolom sesuai form */
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" id="loginCard">
            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="logo-polinema.png" alt="Logo Politeknik Negeri Malang" id="logo">
            </div>
            <!-- Notifikasi Merah Muda -->
            <div id="notification">
                Masukkan username dan password<br>
                (Menggunakan NIM dan password)
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form id="loginForm" action="" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="showPassword">
                    <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
            </form>
            <div class="text-center mt-3">
                <a href="#">Lupa Password?</a>
            </div>
            <div class="text-center mt-3 text-muted">
                2024 © Sistem Tata Tertib JTI
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript untuk menampilkan atau menyembunyikan password
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
