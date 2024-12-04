<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class MahasiswaProfilController implements Controller
{

    function index(): void
    {
        View::render("mahasiswa/profil/index",[
            'data' => [
                'title' => 'Profil'
            ]
        ]);
    }
}