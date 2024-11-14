<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Sistem Tatib JTI</title>
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
        .table th, .table td {
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
                        <a class="nav-link text-white" href="dashboardmhs.php">
                            <i class="fas fa-th-large icon-spacing"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="lapormhs.php">
                            <i class="fas fa-exclamation-circle icon-spacing"></i> Lapor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pelanggaranmhs.php">
                            <i class="fas fa-ban icon-spacing"></i> Pelanggaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="absensimhs.php">
                            <i class="fas fa-calendar-check icon-spacing"></i> Absensi
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
                    <img src="logo-polinema.png" alt="Logo Politeknik Negeri Malang" class="mr-2" style="width: 100px; height: auto;">
                    <h1><b>Politeknik Negeri Malang</b></h1>
                </div>
                <div class="d-flex align-items-center">
                    <div class="profile-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="profile-name"><?php echo htmlspecialchars($username); ?></span>
                </div>
            </div>

            <!-- Tambah Laporan button moved below username! -->
            <div class="d-flex justify-content-end mb-3">
                <button class="btn-tambah-laporan">
                    <i class="fas fa-plus"></i> Tambah Laporan
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
                    <?php if (!empty($data_pelanggaran)) : ?>
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
                        <tr><td colspan="7" class="text-center">Tidak ada data pelanggaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
