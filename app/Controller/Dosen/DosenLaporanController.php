<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenLaporanController implements Controller
{
    private DosenService $dosenService;

    public function __construct()
    {
        $this->dosenService = new DosenServiceImpl(
            Database::getConnection()
        );
    }
    function index(): void
    {
        View::render("admin/laporan/index",[
            'data' => [
                'title' => 'Laporan',
                'listLaporan' => $this->dosenService->getAllLaporan()
            ]
        ]);
    }
}