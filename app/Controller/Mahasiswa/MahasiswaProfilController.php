<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\CurrentUserService;
use Kelompok2\SistemTataTertib\Service\Implementation\CurrentUserServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\MahasiswaServiceImpl;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaProfilController implements Controller
{

    private CurrentUserService $currentUserService;

    private MahasiswaService $mahasiswaService;

    public function __construct()
    {
        $this->currentUserService = new CurrentUserServiceImpl(
            Database::getConnection()
        );

        $this->mahasiswaService = new MahasiswaServiceImpl(
            Database::getConnection()
        );
    }

    function index(): void
    {
        View::render("mahasiswa/profil/index", [
            'data' => [
                'title' => 'Profil',
                'profil' => $this->currentUserService->getInfoUser($this->mahasiswaService->getCurrentUsername())
            ]
        ]);
    }
}