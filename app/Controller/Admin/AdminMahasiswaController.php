<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Model\Admin\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\DetailMahasiswaResponse;
use Kelompok2\SistemTataTertib\Model\User\CreateUserRequest;
use Kelompok2\SistemTataTertib\Repository\Implementation\KelasRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\MahasiswaRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\UserRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\UserServiceImpl;
use Kelompok2\SistemTataTertib\Service\UserService;

class AdminMahasiswaController implements Controller
{
    private AdminService $adminService;

    private UserService $userService;

    public function __construct()
    {
        $this->adminService = new AdminServiceImpl(
            new MahasiswaRepositoryImpl(Database::getConnection()),
            new KelasRepositoryImpl(Database::getConnection()),
            new UserRepositoryImpl(Database::getConnection())
        );
        $this->userService = new UserServiceImpl(
            new UserRepositoryImpl(Database::getConnection())
        );
    }


    function index(): void
    {
        View::render('admin/mahasiswa/index', [
            'data' => [
                'title' => 'Data Mahasiswa',
                'mahasiswaList' => $this->adminService->getAllMahasiswa(),
                'kelasList' => $this->adminService->getAllKelas()
            ]
        ]);
    }

    function createMahasiswa(): void
    {
        $request = new CreateMahasiswaRequest();
        $request->nim = $_POST['nim'];
        $request->nama = $_POST['nama'];
        $request->no_telp = $_POST['noTelp'];
        $request->email = $_POST['email'];
        $request->kelas = $_POST['kelas'];

        try {
            $this->adminService->createMahasiswa($request);
            $userRequest = new CreateUserRequest();
            $userRequest->username = $request->nim;
            $userRequest->password = $request->nim;
            $userRequest->level = 'mahasiswa';
            $this->userService->createUser($userRequest);
            echo json_encode(['status' => 'OK']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    function deleteMahasiswa()
    {
        $request = $_POST['nim'];

        try {
            $this->adminService->deleteMahasiswa($request);
            echo json_encode(['status' => 'OK']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    function detailMahasiswa()
    {
        $request = $_POST['nim'];

        try {
            $mahasiswa = $this->adminService->getDetailMahasiswa($request);
            echo json_encode(['data' => $mahasiswa]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}