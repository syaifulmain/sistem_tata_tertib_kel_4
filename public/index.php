<?php

require_once __DIR__ . '/../vendor/autoload.php';
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
Router::get("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'index', $mustNotLoginMiddleware);
Router::post("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'login', $mustNotLoginMiddleware);
Router::get("/logout", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'logout', $mustLoginMiddleware);

$adminMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustAdminMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];

// ADMIN
Router::get('/admin/home', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'index', $adminMiddleware);

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

// MAHASISWA

$mahasiswaMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustMahasiswaMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];

Router::get('/mahasiswa/home', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaHomeController::class, 'index', $mahasiswaMiddleware);

Router::get('/mahasiswa/pelanggaran', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaPelanggaranController::class, 'index', $mahasiswaMiddleware);

Router::get('/mahasiswa/tatatertib', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\TataTertibController::class, 'index', $mahasiswaMiddleware);

Router::get('/mahasiswa/profil', \Kelompok2\SistemTataTertib\Controller\Mahasiswa\MahasiswaProfilController::class, 'index', $mahasiswaMiddleware);

Router::run();