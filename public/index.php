<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/aplication.php';

use Kelompok2\SistemTataTertib\App\Router;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Admin\AdminMahasiswaController;


header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


Database::getConnection();

Router::get("/", \Kelompok2\SistemTataTertib\Controller\IndexController::class, 'index', []);

$mustLoginMiddleware = [\Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class];
$mustNotLoginMiddleware = [\Kelompok2\SistemTataTertib\Middleware\MustNotLoginMiddleware::class];
Router::get("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'index', $mustNotLoginMiddleware);
Router::post("/login", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'login', $mustNotLoginMiddleware);
Router::get("/logout", \Kelompok2\SistemTataTertib\Controller\UserController::class, 'logout', [
    \Kelompok2\SistemTataTertib\Middleware\MustAdminMiddleware::class
]);


$adminMiddleware = [
    \Kelompok2\SistemTataTertib\Middleware\MustAdminMiddleware::class,
    \Kelompok2\SistemTataTertib\Middleware\MustLoginMiddleware::class
];
Router::get('/admin/home', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'index', $adminMiddleware);

Router::get('/admin/mahasiswa/index',\Kelompok2\SistemTataTertib\Controller\Admin\AdminMahasiswaController::class, 'index', $adminMiddleware);
Router::post('/admin/mahasiswa/tambah', AdminMahasiswaController::class, 'createMahasiswa', $adminMiddleware);
Router::post('/admin/mahasiswa/detail', AdminMahasiswaController::class, 'detailMahasiswa', $adminMiddleware);
Router::post('/admin/mahasiswa/hapus', AdminMahasiswaController::class, 'deleteMahasiswa', $adminMiddleware);

Router::get('/admin/dosen/index', \Kelompok2\SistemTataTertib\Controller\Admin\AdminDosenController::class, 'index', $adminMiddleware);
Router::run();