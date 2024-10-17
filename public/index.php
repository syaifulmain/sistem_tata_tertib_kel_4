<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kelompok2\SistemTataTertib\App\Router;
use Kelompok2\SistemTataTertib\Config\Database;

Database::getConnection('prod');

Router::run();