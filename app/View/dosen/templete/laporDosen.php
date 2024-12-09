<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Dosen';

// Logika untuk mengatur halaman mana yang ditampilkan
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $page == 'lapor') {
    // Proses data laporan
    $nama_pelanggar = $_POST['nama_pelanggar'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $tanggal_pelanggaran = $_POST['tanggal_pelanggaran'];
    $keterangan = $_POST['keterangan'];

    // Simpan ke database (contoh, sesuaikan dengan koneksi Anda)
    // $conn = new mysqli("localhost", "username", "password", "database");
    // $sql = "INSERT INTO laporan (nama_pelanggar, jenis_pelanggaran, tanggal_pelanggaran, keterangan)
    //         VALUES ('$nama_pelanggar', '$jenis_pelanggaran', '$tanggal_pelanggaran', '$keterangan')";
    // $conn->query($sql);

    header("Location: ?page=lapor&success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Tatib JTI - Dosen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 1.5rem;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #112b61;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .nav-link {
            font-size: 1.5rem;
            color: #ffffff;
            display: flex;
            align-items: center;
            padding: 15px 20px;
        }

        .sidebar .nav-link.active {
            background-color: #112b61;
            color: #ffffff;
        }

        .sidebar .nav-link:hover {
            background-color: #001a50;
            color: #ffffff;
        }

        .icon-spacing {
            margin-right: 15px;
        }

        .navbar {
            width: auto;
            padding: 0 100px;
            background-color: #001f5f;
        }

        .logout-btn {
            font-size: 1.5rem;
            background-color: #ff4d4d;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #ff3333;
        }

        .content {
            background-color: #f8f9fa;
        }

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
            color: #000000;
        }

        .btn-tambah-laporan {
            background-color: #112b61;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .btn-tambah-laporan i {
            margin-right: 8px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #fff;
        }
        
    </style>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar">
            <div>
                <h2 class="p-3 text-center text-white">Sistem Tata Tertib</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'dashboard' ? 'active' : ''; ?> text-white"
                            href="?page=dashboard">
                            <i class="fas fa-th-large icon-spacing"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'lapor' ? 'active' : ''; ?> text-white"
                            href="?page=lapor">
                            <i class="fas fa-exclamation-circle icon-spacing"></i> Lapor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page == 'pelanggaran' ? 'active' : ''; ?> text-white"
                            href="?page=pelanggaran">
                            <i class="fas fa-ban icon-spacing"></i> Pelanggaran
                        </a>
                    </li>
                </ul>
            </div>
            <a class="logout-btn" href="logout.php">
                <i class="fas fa-sign-out-alt icon-spacing"></i> Logout
            </a>
        </nav>

        <div class="content flex-grow-1 p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <img src="logo-polinema.png" alt="Logo Politeknik Negeri Malang" class="mr-2"
                        style="width: 100px; height: auto;">
                    <h1><b>Politeknik Negeri Malang</b></h1>
                </div>
                <div class="d-flex align-items-center">
                    <div class="profile-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="biodata.php" class="profile-link">
                        <span class="profile-name"><?php echo htmlspecialchars($username); ?></span>
                    </a>
                </div>
            </div>

            <?php if ($page == 'dashboard') { ?>
                <!-- Dashboard Section -->
                <h1>Dashboard</h1>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-light text-center p-3">
                            <h4>Total Laporan Tahun Ini</h4>
                            <h3>0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light text-center p-3">
                            <h4>Total Pelanggaran Semester Ini</h4>
                            <h3>0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light text-center p-3">
                            <h4>Total Pelanggaran Keseluruhan</h4>
                            <h3>0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light text-center p-3">
                            <h4>Total Alpha</h4>
                            <h3>0</h3>
                        </div>
                    </div>
                </div>

            <?php } elseif ($page == 'lapor') { ?>
                <!-- Lapor Section -->

                <!-- Pilih Semester dan Tambah Laporan -->
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <div class="semester-select">
                        <select class="form-control" style="width: 180px;">
                            <option value="ganjil">Semester Ganjil</option>
                            <option value="genap">Semester Genap</option>
                        </select>
                    </div>

                    <!-- Button Tambah Laporan -->
                    <button class="btn-tambah-laporan" id="btn-tambah-laporan">
                        <a href="javascript:void(0)" class="text-white">
                            <i class="fas fa-plus"></i> Tambah Laporan
                        </a>
                    </button>

                    <!-- Form Laporan (Disembunyikan di awal) -->
                    <div id="form-laporan" style="display: none; margin-top: 20px;">
                        <h1>Laporan Pelanggaran</h1>
                        <form action="?page=lapor" method="POST">
                            <!-- Input Nama Pelanggar -->
                            <div class="form-group">
                                <label for="nama_pelanggar">Nama Pelanggar</label>
                                <input type="text" name="nama_pelanggar" class="form-control" required>
                            </div>

                            <!-- Input Jenis Pelanggaran -->
                            <div class="form-group">
                                <label for="jenis_pelanggaran">Jenis Pelanggaran</label>
                                <input type="text" name="jenis_pelanggaran" class="form-control" required>
                            </div>

                            <!-- Input Tanggal Pelanggaran -->
                            <div class="form-group">
                                <label for="tanggal_pelanggaran">Tanggal Pelanggaran</label>
                                <input type="date" name="tanggal_pelanggaran" class="form-control" required>
                            </div>

                            <!-- Input Keterangan -->
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="4"></textarea>
                            </div>

                            <!-- Button Submit -->
                            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                        </form>
                    </div>

                    <!-- JavaScript untuk Menampilkan/Sembunyikan Form -->
                    <script>
                        document.getElementById('btn-tambah-laporan').addEventListener('click', function () {
                            var formLaporan = document.getElementById('form-laporan');
                            // Menampilkan atau menyembunyikan form
                            if (formLaporan.style.display === "none") {
                                formLaporan.style.display = "block";
                            } else {
                                formLaporan.style.display = "none";
                            }
                        });
                    </script>


                    </button>
                </div>

                <h1>Daftar Riwayat Pelaporan</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggar</th>
                            <th>Pelanggaran</th>
                            <th>Tingkat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php if (!empty($data_pelanggaran)): ?>
                            <?php foreach ($data_pelanggaran as $index => $row): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $row['nama_pelanggar']; ?></td>
                                    <td><?php echo $row['pelanggaran']; ?></td>
                                    <td><?php echo $row['tingkat']; ?></td>
                                    <td><?php echo $row['tanggal']; ?></td>
                                    <td><span class="badge badge-warning"><?php echo $row['status']; ?></span></td>
                                    <td><button class="btn btn-info btn-sm">Detail</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pelanggaran</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>

<?php } elseif ($page == 'pelanggaran') { ?>
    <!-- Pelanggaran Section -->
    <h1>Daftar Pelanggaran</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggar</th>
                <th>Jenis Pelanggaran</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Contoh data pelanggaran -->
            <tr>
                <td>1</td>
                <td>Boy Wiliam</td>
                <td>Tidak hadir</td>
                <td>2024-12-01</td>
                <td>Tanpa keterangan</td>
                <td>
                    <a href="editpelanggaran.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                    <a href="deletepelanggaran.php?id=1" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>

</div>
</div>
</body>

</html>