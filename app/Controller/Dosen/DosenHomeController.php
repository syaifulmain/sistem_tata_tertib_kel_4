<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenHomeController implements Controller
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
        View::render("dosen/index",[
            'title' => 'Dashboard Dosen',
            'data' => [
            ]
        ]);
    }

    function getLaporanPertahun()
    {
        $tahun = $_GET['tahun'];

        try {
            $response = $this->dosenService->getLaporanPertahun($tahun);
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
            $response = $this->dosenService->getAllTahun();
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