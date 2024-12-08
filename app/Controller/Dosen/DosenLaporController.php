<?php

namespace Kelompok2\SistemTataTertib\Controller\Dosen;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Model\Dosen\LaporMahasiswaRequest;
use Kelompok2\SistemTataTertib\Service\DosenService;
use Kelompok2\SistemTataTertib\Service\Implementation\DosenServiceImpl;

class DosenLaporController implements Controller
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
        View::render('dosen/lapor/index', [
            'data' => [
                'title' => 'Lapor',
                'listRiwayatLapor' => $this->dosenService->getAllRiwayatLaporMahasiswaCurrentDosen(),
                'listKlasifikasi' => $this->dosenService->getALlKlasifikasi(),
                'listMahasiswa' => $this->dosenService->getAllMahasiswa()
            ]
        ]);
    }

    function buatLaporan()
    {
        $uploadDir = 'resources/buktipelanggaran/';

        $newFileName = null;
        if (isset($_FILES['inputBukti']) && $_FILES['inputBukti']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['inputBukti']['tmp_name'];
            $fileName = $_FILES['inputBukti']['name'];
            $fileSize = $_FILES['inputBukti']['size'];
            $fileType = $_FILES['inputBukti']['type'];

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


        $request = new LaporMahasiswaRequest(
            $_POST['inputMahasiswa'],
            $this->dosenService->getCurrentUsername(),
            $_POST['inputTanggal'],
            $_POST['inputKlasifikasi'],
            $_POST['inputDeskripsi'],
            $newFileName
        );

        try {
            $this->dosenService->laporMahasiwa($request);
//            View::render('dosen/lapor/index',[
//                'title' => 'Lapor'
//            ]);
            echo json_encode([
                'status' => 'success',
                'message' => 'Laporan berhasil dibuat'
            ]);
        } catch (\Exception $exception) {
            echo json_encode([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    function getDetailLaporan()
    {
        $id = $_POST['id'];
        try {
            $data = $this->dosenService->getDetailRiwayatLaporan($id);
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $exception) {
            echo json_encode([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}