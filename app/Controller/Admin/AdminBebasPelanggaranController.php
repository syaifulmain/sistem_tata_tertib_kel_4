<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;

class AdminBebasPelanggaranController implements Controller
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
        View::render("admin/bebaspelanggaran/index",[
            'data' => [
                'title' => 'Bebas Pelanggaran',
                'listLaporanPelanggaran' => $this->adminService->getAllLaporanPelanggaran()
            ]
        ]);
    }

    function getDetailLaporanPelanggaran()
    {
        $id = $_GET['id'];

        try {
            $response = $this->adminService->getDetailLaporanPelanggaran($id);
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