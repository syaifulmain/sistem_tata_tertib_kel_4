<?php
// session_start();
// include('config.php');

// // Mengambil data username dari session
// $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

// // Mengambil data riwayat pelanggaran dari database
// $query = "SELECT id, pelanggaran, tingkat, tanggal, status FROM riwayat_pelanggaran WHERE mahasiswa_id = ?";
// $stmt = $conn->prepare($query);
// $stmt->bind_param("i", $_SESSION['mahasiswa_id']); 
// $stmt->execute();
// $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggaran Sistem Tatib JTI</title>
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
            padding: 20px;
            flex-grow: 1;
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
                        <a class="nav-link active text-white" href="pelanggaranmhs.php">
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

            <h1>Daftar Riwayat Pelanggaran</h1>
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
                    <?php if ($result->num_rows > 0): ?>
                        <?php 
                        $no = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row['pelanggaran']; ?></td>
                                <td><?php echo $row['tingkat']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($row['tanggal'])); ?></td>
                                <td><span class="badge badge-warning"><?php echo $row['status']; ?></span></td>
                                <td><button class="btn btn-info btn-sm">Detail</button></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Tidak ada data pelanggaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Menutup koneksi database
// $stmt->close();
// $conn->close();
// a
?>
