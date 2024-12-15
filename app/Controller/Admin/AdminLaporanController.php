<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;

class AdminLaporanController implements Controller
{

    private AdminService $adminService;

    public function __construct()
    {
        $this->adminService = new AdminServiceImpl(
            Database::getConnection()
        );
    }

    function index(): void
    {
        View::render("admin/laporan/index",[
            'title' => 'Laporan',
            'data' => [
                'listLaporan' => $this->adminService->getAllLaporan()
            ]
        ]);
    }

    function getAllLaporan()
    {
        try {
            $response = $this->adminService->getAllLaporan();
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

    function getDetailLaporan()
    {
        $id = $_GET['id'];

        try {
            $response = $this->adminService->getDetailLaporan($id);
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