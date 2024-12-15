<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;

class AdminHomeController implements Controller
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
        View::render('admin/index', [
            'title' => 'Dashboard Admin',
            'data' => [
            ]
        ]);
    }

    function getLaporanPertahun()
    {
        $tahun = $_GET['tahun'];

        try {
            $response = $this->adminService->getLaporanPertahun($tahun);
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
            $response = $this->adminService->getAllTahun();
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