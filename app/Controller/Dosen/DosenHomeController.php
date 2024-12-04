<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class DosenHomeController implements Controller
{

    function index(): void
    {
        View::render("dosen/index",[
            'data' => [
                'title' => 'Dashboard Dosen'
            ]
        ]);
    }
}