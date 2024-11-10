<?php
// session_start(); // Uncomment if sessions are needed
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
//     header("Location: ../login/login.php");
//     exit();
// }
// $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Pelanggaran - Sistem Tata Tertib</title>
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
        }
        .sidebar .nav-link.active {
            background-color: #112b61;
            color: #ffffff;
        }
        .sidebar .nav-link:hover {
            background-color: #001a50;
            color: #ffffff;
        }
        .navbar {
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
        .icon-spacing {
            margin-right: 20px;
            font-size: 1.2rem;
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
                        <a class="nav-link text-white" href="dashboard.php">
                            <i class="fas fa-th-large icon-spacing"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="lapormhs.php">
                            <i class="fas fa-exclamation-circle icon-spacing"></i> Lapor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pelanggaran.php">
                            <i class="fas fa-ban icon-spacing"></i> Pelanggaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="absensi.php">
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

            <!-- Form Lapor Pelanggaran -->
            <h1>Lapor Pelanggaran</h1>
            <form method="post" action="process_lapor.php">
                <div class="form-group">
                    <label for="pelanggaran">Jenis Pelanggaran</label>
                    <input type="text" class="form-control" id="pelanggaran" name="pelanggaran" required>
                </div>
                <div class="form-group">
                    <label for="tingkat">Tingkat Pelanggaran</label>
                    <select class="form-control" id="tingkat" name="tingkat" required>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Laporan</button>
            </form>
        </div>
    </div>
</body>
</html>
