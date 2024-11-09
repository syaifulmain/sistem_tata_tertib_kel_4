<?php
// session_start(); // Memulai sesi untuk mengakses data pengguna

// // Memastikan bahwa pengguna telah login dan ada data username di sesi
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
//     header("Location: ../login/login.php");
//     exit();
// }

// // Simpan username ke variabel untuk kemudahan
// $username = $_SESSION['username'];

// // Koneksi database (sesuaikan nama database, username, dan password)
// try {
//     $conn = new PDO("mysql:host=localhost;dbname=NamaDatabaseAnda", "username", "password");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Query data pelanggaran
//     $query = "SELECT * FROM pelanggaran ORDER BY tanggal DESC LIMIT 10";
//     $stmt = $conn->query($query);

//     if ($stmt) {
//         $data_pelanggaran = $stmt->fetchAll();
//     } else {
//         $data_pelanggaran = []; // Pastikan sebagai array kosong jika query gagal
//     }
// } catch (Exception $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }
?>

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
            background-color: #1d2277; /* Warna latar belakang sidebar */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .nav-link {
            font-size: 1.5rem; /* Membesarkan ukuran teks navigasi */
            color: #ffffff; /* Warna teks navigasi */
        }
        .sidebar .nav-link.active {
            background-color: #1d2277; /* Warna latar untuk item aktif */
            color: #ffffff;
        }
        .sidebar .nav-link:hover {
            background-color: #001a50; /* Warna latar untuk efek hover */
            color: #ffffff;
        }

        /* Gaya untuk Navbar */
        .navbar {
            width: auto; /* Biarkan lebarnya otomatis */
            padding: 0 100px; /* Tambahkan padding kiri dan kanan untuk memperlebar */
            background-color: #001f5f;
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
            margin-right: 20px; /* Atur jarak ikon */
            font-size: 1.2rem; /* Sesuaikan ukuran ikon jika perlu */
        }

        /* Gaya untuk tampilan profil pengguna di kanan atas */
        .navbar-profile {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        .profile-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            margin-right: 8px;
        }
        .profile-name {
            font-weight: bold;
            color: #000000; /* Ubah warna teks nama pengguna sesuai keinginan */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="d-flex">
        <nav class="sidebar">
            <div>
                <h2 class="p-3 text-center text-white">Sistem Tata Tertib</h2>
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
            <!-- Bagian Profil Pengguna di Kanan Atas -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <!-- Gambar Logo -->
                    <img src="logo-polinema.png" alt="Logo Politeknik Negeri Malang" class="mr-2" style="width: 100px; height: auto;">
                    <!-- Teks Judul -->
                    <h1>Politeknik Negeri Malang</h1>
                </div>
            <div class="navbar-profile">
                <div class="profile-icon">
                    <i class="fas fa-user"></i> <!-- Ikon profil -->
                </div>
                <span class="profile-name"><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>
            <!-- Konten Dashboard -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Tahun Ini</h6>
                        <h3>0</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Semester Ini</h6>
                        <h3>0</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Pelanggaran Keseluruhan</h6>
                        <h3>0</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light text-center p-3">
                        <h6>Total Alpha</h6>
                        <h3>0</h3>
                    </div>
                </div>
            </div>

            <!-- Tabel Pelanggaran Terbaru -->
            <h1>Pelanggaran Terbaru</h1>
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
                    <?php if (!empty($data_pelanggaran)) : ?>
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
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Tidak ada data pelanggaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
