<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kelompok2\SistemTataTertib\App\Router;
use Kelompok2\SistemTataTertib\Config\Database;

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
Router::get('/home/admin', \Kelompok2\SistemTataTertib\Controller\Admin\AdminHomeController::class, 'index', $adminMiddleware);
Router::run();