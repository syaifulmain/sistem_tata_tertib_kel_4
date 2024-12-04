<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Controller\Controller;

class MahasiswaPelanggaranController implements Controller
{

    function index(): void
    {
        View::render("mahasiswa/pelanggaran/index",[
            'data' => [
                'title' => 'Pelanggaran'
            ]
        ]);
    }
}