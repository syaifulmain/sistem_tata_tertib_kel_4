<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class TataTertibController implements Controller
{

    function index(): void
    {
        View::render("mahasiswa/tatatertib/index",[
            'data' => [
                'title' => 'Tata Tertib'
            ]
        ]);
    }
}