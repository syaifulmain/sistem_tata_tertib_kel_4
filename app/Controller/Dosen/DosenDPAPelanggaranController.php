<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenDPAPelanggaranController implements Controller
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
        View::render("dosen/DPA/pelanggaran/index",[
            'title' => 'Laporan',
            'data' => [

                'listPelanggaranMahasiswa' => $this->dosenService->getListPelanggaranMahasiswa()
            ]
        ]);
    }

    function getDetailLaporanPelanggaran()
    {
        $id = $_GET['id'];

        try {
            $response = $this->dosenService->getDetailPelanggaranMahasiswa($id);
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