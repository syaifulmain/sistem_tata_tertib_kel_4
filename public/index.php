<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kelompok2\SistemTataTertib\App\Router;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\DashboardController;
use Kelompok2\SistemTataTertib\Controller\HomeController;
use Kelompok2\SistemTataTertib\Controller\mahasiswa\MahasiswaController;
use Kelompok2\SistemTataTertib\Controller\PeraturanController;

Database::getConnection();

Router::get("/", HomeController::class, 'index');

Router::get("/dashboard", DashboardController::class, 'index');
Router::get("/peraturan/index", PeraturanController::class, 'index');

Router::get("/biodata/mahasiswa/index", MahasiswaController::class, 'biodata');

Router::run();