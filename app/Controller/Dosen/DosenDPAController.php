<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenDPAController implements Controller
{
    private DosenService $dosenService;

    private AdminService $adminService;

    public function __construct()
    {
        $this->dosenService = new DosenServiceImpl(
            Database::getConnection()
        );
        $this->adminService = new AdminServiceImpl(
            Database::getConnection()
        );
    }
    function index(): void
    {
        View::render("dosen/DPA/laporan/index",[
            'title' => 'Laporan',
            'data' => [
                'listLaporan' => $this->dosenService->getAllLaporan()
            ]
        ]);
    }

    function getDetailLaporan()
    {
        $id = $_GET['id'];

        try {
            $response = $this->dosenService->getDetailLaporan($id);
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

    function kirimLaporan()
    {
        $id = $_POST['id'];
        $tingkat = $_POST['tingkat'];

        try {
            $this->adminService->kirimLaporan($id, $tingkat);
            echo json_encode([
                'status' => 'OK',
                'message' => 'Laporan berhasil dikirim'
            ]);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo json_encode([
                'status' => 'ERROR',
                'message' => $exception->getMessage()
            ]);
        }
    }

    function batalkanLaporan()
    {
        $id = $_POST['id'];

        try {
            $this->adminService->batalkanLaporan($id);
            echo json_encode([
                'status' => 'OK',
                'message' => 'Laporan berhasil dibatalkan'
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