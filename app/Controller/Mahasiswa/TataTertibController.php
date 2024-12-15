<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\Implementation\PelanggaranServiceImpl;
use Kelompok2\SistemTataTertib\Service\PelanggaranService;

class TataTertibController implements Controller
{

    private PelanggaranService $pelanggaranService;

    public function __construct()
    {
        $this->pelanggaranService = new PelanggaranServiceImpl(
            Database::getConnection()
        );
    }

    function index(): void
    {
        View::render("mahasiswa/tatatertib/index",[
            'title' => 'Tata Tertib',
            'data' => [
                'listKlasifikasiPelanggaran' => $this->pelanggaranService->getAllKlasifikasi()
            ]
        ]);
    }
}