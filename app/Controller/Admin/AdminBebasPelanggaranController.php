<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class AdminBebasPelanggaranController implements Controller
{

    function index(): void
    {
        View::render("admin/bebaspelanggaran/index",[
            'data' => [
                'title' => 'Bebas Pelanggaran'
            ]
        ]);
    }
}