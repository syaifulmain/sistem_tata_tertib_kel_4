<?php
// // Cek sesi login atau autentikasi jika diperlukan
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }

// // Koneksi database (sesuaikan nama database, username, dan password)
// try {
//     $conn = new PDO("mysql:host=localhost;dbname=NamaDatabaseAnda", "username", "password");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (Exception $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }

// // Query data dummy atau sesuaikan query untuk data pelanggaran
// $query = "SELECT * FROM pelanggaran ORDER BY tanggal DESC LIMIT 10";
// $data_pelanggaran = $conn->query($query)->fetchAll();
// ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Tata Tertib</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        /* CSS Global untuk memperbesar teks */
        body {
            font-size: 1.5rem; /* Membesarkan teks di seluruh website */
        }

        /* Gaya untuk Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #000f3f; /* Warna latar belakang sidebar */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .nav-link {
            font-size: 1.5rem; /* Membesarkan ukuran teks navigasi */
            color: #ffffff; /* Warna teks navigasi */
        }
        .sidebar .nav-link.active {
            background-color: #001f5f; /* Warna latar untuk item aktif */
            color: #ffffff;
        }
        .sidebar .nav-link:hover {
            background-color: #001a50; /* Warna latar untuk efek hover */
            color: #ffffff;
        }

        .navbar {
            width: auto; /* Biarkan lebarnya otomatis */
            padding: 0 100px; /* Tambahkan padding kiri dan kanan untuk memperlebar */
            background-color: #001f5f; /* Ganti dengan warna background navbar yang diinginkan */
        }

        /* Gaya untuk Tombol Logout */
        .logout-btn {
            font-size: 1.5rem; /* Membesarkan teks tombol logout */
            background-color: #ff4d4d; /* Warna latar merah untuk tombol logout */
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .logout-btn:hover {
            background-color: #ff3333; /* Warna latar hover untuk tombol logout */
        }

        /* Gaya untuk Konten Utama */
        .content {
            background-color: #f8f9fa;
        }
        .card h6 {
            font-size: 1.5rem;
            font-weight: normal;
        }
        .card h3 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        /* Tabel Pelanggaran */
        .table-bordered {
            background-color: #fff;
        }
        .table-bordered th, .table-bordered td {
            vertical-align: middle;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #fff;
        }
        /* Atur jarak antara ikon dan teks */
.icon-spacing {
    margin-right: 20px; /* Anda bisa mengubah nilai ini untuk menyesuaikan jarak */
    font-size: 1.2rem; /* Sesuaikan ukuran ikon jika perlu */
}
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="d-flex">
    <nav class="sidebar">
    <div>
        <h2 class="p-3 text-center text-white">Sistem Tatib</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active text-white" href="#">
                    <i class="fas fa-th-large icon-spacing"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-exclamation-circle icon-spacing"></i> Lapor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-ban icon-spacing"></i> Pelanggaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-calendar-check icon-spacing"></i> Absensi
                </a>
            </li>
        </ul>
    </div>
    <!-- Tombol Logout -->
    <a class="logout-btn" href="logout.php">
        <i class="fas fa-sign-out-alt icon-spacing"></i> Logout
    </a>
</nav>

        <!-- Konten Utama -->
        <div class="content flex-grow-1 p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard</h2>
                <div class="user-info">
                    <span class="text-muted">Nama</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Tahun Ini</h6>
                        <h3>20</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Semester Ini</h6>
                        <h3>20</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Keseluruhan</h6>
                        <h3>20</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Alpha</h6>
                        <h3>20</h3>
                    </div>
                </div>
            </div>

            <!-- Tabel Pelanggaran Terbaru -->
            <h5>Pelanggaran Terbaru</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggaran</th>
                        <th>Tingkat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_pelanggaran as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $row['pelanggaran']; ?></td>
                            <td><?php echo $row['tingkat']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><span class="badge badge-warning">Proses</span></td>
                            <td><button class="btn btn-info btn-sm">Detail</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
