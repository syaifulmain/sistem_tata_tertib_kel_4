<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\Implementation\MahasiswaServiceImpl;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaHomeController implements Controller
{
    private MahasiswaService $mahasiswaService;

    public function __construct()
    {
        $this->mahasiswaService = new MahasiswaServiceImpl(
            Database::getConnection()
        );
    }
    function index(): void
    {
        View::render("mahasiswa/index",[
            'title' => 'Home',
            'data' => [

            ]
        ]);
    }

    function getLaporanPertahun()
    {
        $tahun = $_GET['tahun'];

        try {
            $response = $this->mahasiswaService->getLaporanPertahun($tahun);
            echo json_encode([
                'status' => 'OK',
                'data' => $response
            ]);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo json_encode([
                'status' => 'ERROR',
                'message' => $exception->getMessage()
            ]);
        }
    }

    function getAllTahun()
    {
        try {
            $response = $this->mahasiswaService->getAllTahun();
            echo json_encode([
                'status' => 'OK',
                'data' => $response
            ]);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo json_encode([
                'status' => 'ERROR',
                'message' => $exception->getMessage()
            ]);
        }
    }
}