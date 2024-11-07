<?php

namespace Kelompok2\SistemTataTertib\Controller\mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Repository\Implementation\MahasiswaRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\MahasiswaServiceImpl;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaController implements Controller
{

    private MahasiswaService $mahasiswaService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $this->mahasiswaService = new MahasiswaServiceImpl(new MahasiswaRepositoryImpl($connection));
    }


    function index()
    {
        // TODO: Implement index() method.
    }

    function biodata()
    {
        View::render("biodata-mahasiswa",[
            'data' => $this->mahasiswaService->getMahasiswa("2341720013")
        ]);

    }
}