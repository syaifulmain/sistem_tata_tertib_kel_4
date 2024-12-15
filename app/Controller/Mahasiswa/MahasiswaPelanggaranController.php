<?php

namespace Kelompok2\SistemTataTertib\Controller\Mahasiswa;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Model\Mahasiswa\KirimSuratPernyataanRequest;
use Kelompok2\SistemTataTertib\Service\Implementation\MahasiswaServiceImpl;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaPelanggaranController implements Controller
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
        View::render("mahasiswa/pelanggaran/index",[
            'title' => 'Pelanggaran',
            'data' => [

                'listPelanggaran' => $this->mahasiswaService->getAllPelanggaran()
            ]
        ]);
    }

    function kirimSuratPernyataan()
    {
        $uploadDir = 'resources/suratbebassaksi/';

        $newFileName = null;
        if (isset($_FILES['inputbebassanksi']) && $_FILES['inputbebassanksi']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['inputbebassanksi']['tmp_name'];
            $fileName = $_FILES['inputbebassanksi']['name'];
            $fileSize = $_FILES['inputbebassanksi']['size'];
            $fileType = $_FILES['inputbebassanksi']['type'];

            $fileNameCmps = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $fileNameCmps;

            $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'pdf');
            if (in_array($fileNameCmps, $allowedfileExtensions)) {

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully!', 'file' => $newFileName]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'There was an error moving the file.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
        }

        $request = new KirimSuratPernyataanRequest(
            id: $_POST['pelanggaranId'],
            suratPernyataan: $newFileName
        );

        try {
            $this->mahasiswaService->simpanSuratPernyataan($request);
            echo json_encode(['status' => 'OK']);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo json_encode(['status' => 'ERROR', 'message' => $exception->getMessage()]);
        }
    }

    function getDetailPelanggaran()
    {
        $id = $_GET['id'];

        try {
            $response = $this->mahasiswaService->getDetailPelanggaran($id);
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