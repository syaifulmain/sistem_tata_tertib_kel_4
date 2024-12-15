<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\CurrentUserService;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\CurrentUserServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenProfilController implements Controller
{


    private CurrentUserService $currentUserService;

    private DosenService $dosenService;

    public function __construct()
    {
        $this->currentUserService = new CurrentUserServiceImpl(
            Database::getConnection()
        );

        $this->dosenService = new DosenServiceImpl(
            Database::getConnection()
        );
    }

    function index(): void
    {
        View::render("dosen/profil/index", [
            'title' => 'Profil',
            'data' => [
                'profil' => $this->currentUserService->getInfoUser($this->dosenService->getCurrentUsername())
            ]
        ]);
    }
}