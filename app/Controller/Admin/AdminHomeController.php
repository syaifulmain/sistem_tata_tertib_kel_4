<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class AdminHomeController implements Controller
{

    function index(): void
    {
        View::render('admin/index', [
            'title' => 'Dashboard Admin',
            'data' => [
            ]
        ]);
    }
}