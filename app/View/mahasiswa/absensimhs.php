<?php
// session_start();
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
//     header("Location: ../login/login.php");
//     exit();
// }

// $username = $_SESSION['username'];

// Database connection (adjust as needed)
// try {
//     $conn = new PDO("mysql:host=localhost;dbname=NamaDatabaseAnda", "username", "password");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Pagination logic
//     $limit = 10; // Number of records per page
//     $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
//     $offset = ($page - 1) * $limit;

//     // Fetch data with pagination
//     $query = "SELECT * FROM presensi_mahasiswa LIMIT :limit OFFSET :offset";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
//     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
//     $stmt->execute();
//     $data_presensi = $stmt->fetchAll();

//     // Get total records to calculate total pages
//     $totalQuery = "SELECT COUNT(*) FROM presensi_mahasiswa";
//     $totalRecords = $conn->query($totalQuery)->fetchColumn();
//     $totalPages = ceil($totalRecords / $limit);

// } catch (Exception $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Sistem Tatib JTI</title>
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
                        <a class="nav-link text-white" href="lapormhs.php">
                            <i class="fas fa-exclamation-circle icon-spacing"></i> Lapor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pelanggaranmhs.php">
                            <i class="fas fa-ban icon-spacing"></i> Pelanggaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="absensimhs.php">
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
                <div class="navbar-profile">
                    <div class="profile-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="profile-name"><?php echo htmlspecialchars($username); ?></span>
                </div>
            </div>

            <h1>Data Presensi Mahasiswa</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>Pertemuan</th>
                        <th>Tanggal</th>
                        <th>Alpha</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data_presensi)) : ?>
                        <?php foreach ($data_presensi as $index => $row): ?>
                            <tr>
                                <td><?php echo $index + 1 + $offset; ?></td>
                                <td><?php echo htmlspecialchars($row['mata_kuliah']); ?></td>
                                <td><?php echo htmlspecialchars($row['pertemuan']); ?></td>
                                <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                <td><?php echo htmlspecialchars($row['alpha']); ?></td>
                                <td><?php echo htmlspecialchars($row['izin']); ?></td>
                                <td><?php echo htmlspecialchars($row['sakit']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Tidak ada data presensi</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
