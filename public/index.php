<?php

//require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/aplication.php';

use Kelompok2\SistemTataTertib\App\Router;
use Kelompok2\SistemTataTertib\Config\Database;


header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


Database::getConnection();

Router::get("/", \Kelompok2\SistemTataTertib\Controller\IndexController::class, 'index', []);

$mustLoginMiddleware = [\Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class];
$mustNotLoginMiddleware = [\Kelompok2\SistemTataTertib\Middleware\MustNotLoginMiddleware::class];

Router::get("/home", \Kelompok2\SistemTataTertib\Controller\HomeController::class, 'index', $mustNotLoginMiddleware);
Router::get("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'index', $mustNotLoginMiddleware);
Router::post("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'login', $mustNotLoginMiddleware);
Router::get("/logout", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'logout', $mustLoginMiddleware);

$adminMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustAdminMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];

// ADMIN
Router::get('/admin/home', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'index', $adminMiddleware);

Router::get('/admin/bebaspelanggaran', \Kelompok2\SistemTataTertib\Controller\Admin\AdminBebasPelanggaranController::class, 'index', $adminMiddleware);
Router::get('/admin/bebaspelanggaran/detail', \Kelompok2\SistemTataTertib\Controller\Admin\AdminBebasPelanggaranController::class, 'getDetailLaporanPelanggaran', $adminMiddleware);
Router::post('/admin/bebaspelanggaran/bebas', \Kelompok2\SistemTataTertib\Controller\Admin\AdminBebasPelanggaranController::class, 'bebasPelanggaran', $adminMiddleware);

Router::get('/admin/laporan', \Kelompok2\SistemTataTertib\Controller\Admin\AdminLaporanController::class, 'index', $adminMiddleware);
Router::get('/admin/laporan/getall', \Kelompok2\SistemTataTertib\Controller\Admin\AdminLaporanController::class, 'getAllLaporan', $adminMiddleware);
Router::get('/admin/laporan/detaillaporan', \Kelompok2\SistemTataTertib\Controller\Admin\AdminLaporanController::class, 'getDetailLaporan', $adminMiddleware);
Router::post('/admin/laporan/kirimlaporan', \Kelompok2\SistemTataTertib\Controller\Admin\AdminLaporanController::class, 'kirimLaporan', $adminMiddleware);
Router::post('/admin/laporan/batalkanlaporan', \Kelompok2\SistemTataTertib\Controller\Admin\AdminLaporanController::class, 'batalkanLaporan', $adminMiddleware);

Router::get('/admin/laporanpertahun', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'getLaporanPertahun', $adminMiddleware);
Router::get('/admin/alltahun', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'getAllTahun', $adminMiddleware);

// DOSEN

$dosenMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustDosenMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];

Router::get('/dosen/home', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenHomeController::class, 'index', $dosenMiddleware);
Router::get('/dosen/lapor', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenLaporController::class, 'index', $dosenMiddleware);
Router::post('/dosen/lapor/tambah', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenLaporController::class, 'buatLaporan', $dosenMiddleware);
Router::post('/dosen/lapor/detaillaporan', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenLaporController::class, 'getDetailLaporan', $dosenMiddleware);

Router::get('/dosen/laporan', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAController::class, 'index', $dosenMiddleware);
Router::get('/dosen/laporan/detaillaporan', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAController::class, 'getDetailLaporan', $dosenMiddleware);
Router::post('/dosen/laporan/kirimlaporan', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAController::class, 'kirimLaporan', $dosenMiddleware);
Router::post('/dosen/laporan/batalkanlaporan', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAController::class, 'batalkanLaporan', $dosenMiddleware);

Router::get('/dosen/pelanggaran', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAPelanggaranController::class, 'index', $dosenMiddleware);
Router::get('/dosen/pelanggaran/detail', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenDPAPelanggaranController::class, 'getDetailLaporanPelanggaran', $dosenMiddleware);

Router::get('/dosen/profil', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenProfilController::class, 'index', $dosenMiddleware);
Router::get('/dosen/laporanpertahun', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenHomeController::class, 'getLaporanPertahun', $dosenMiddleware);
Router::get('/dosen/alltahun', \Kelompok2\SistemTataTertib\Controller\Dosen\DosenHomeController::class, 'getAllTahun', $dosenMiddleware);

// MAHASISWA

$mahasiswaMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustMahasiswaMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];

Router::get('/mahasiswa/home', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaHomeController::class, 'index', $mahasiswaMiddleware);

Router::get('/mahasiswa/pelanggaran', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaPelanggaranController::class, 'index', $mahasiswaMiddleware);
Router::post('/mahasiswa/pelanggaran/kirimbebassanksi', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaPelanggaranController::class, 'kirimSuratPernyataan', $mahasiswaMiddleware);
Router::get('/mahasiswa/pelanggaran/getdetail', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaPelanggaranController::class, 'getDetailPelanggaran', $mahasiswaMiddleware);
Router::get('/mahasiswa/tatatertib', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\TataTertibController::class, 'index', $mahasiswaMiddleware);

Router::get('/mahasiswa/profil', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaProfilController::class, 'index', $mahasiswaMiddleware);
Router::get('/mahasiswa/laporanpertahun', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaHomeController::class, 'getLaporanPertahun', $mahasiswaMiddleware);
Router::get('/mahasiswa/alltahun', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaHomeController::class, 'getAllTahun', $mahasiswaMiddleware);

Router::run();