<?php

namespace Kelompok2\SistemTataTertib\Controller\Admin;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Controller\Controller;
use Kelompok2\SistemTataTertib\Model\Admin\Dosen\CreateDosenRequest;
use Kelompok2\SistemTataTertib\Model\User\CreateUserRequest;
use Kelompok2\SistemTataTertib\Repository\Implementation\DosenRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\KelasRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\MahasiswaRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\UserRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\AdminService;
use Kelompok2\SistemTataTertib\Service\Implementation\AdminServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\UserServiceImpl;
use Kelompok2\SistemTataTertib\Service\UserService;

class AdminDosenController implements Controller
{
    private AdminService $adminService;

    private UserService $userService;

    public function __construct()
    {
        $this->adminService = new AdminServiceImpl(
            new MahasiswaRepositoryImpl(Database::getConnection()),
            new DosenRepositoryImpl(Database::getConnection()),
            new KelasRepositoryImpl(Database::getConnection()),
            new UserRepositoryImpl(Database::getConnection())
        );
        $this->userService = new UserServiceImpl(
            new UserRepositoryImpl(Database::getConnection())
        );
    }

    function index(): void
    {
        try {
            View::render('admin/dosen/index', [
                'title' => 'Data Dosen',
                'data' => [
                    'dosenList' => $this->adminService->getAllDosen()
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    function createDosen(): void
    {
        $request = new CreateDosenRequest();
        $request->nip = $_POST['nip'];
        $request->nama = $_POST['nama'];
        $request->no_telp = $_POST['noTelp'];
        $request->email = $_POST['email'];
        $request->kelas = $_POST['kelas'];

        try {
            $this->adminService->createDoesn($request);
            $userRequest = new CreateUserRequest();
            $userRequest->username = $request->nip;
            $userRequest->password = $request->nip;
            $userRequest->level = 'dosen';
            $this->userService->createUser($userRequest);
            echo json_encode(['status' => 'OK']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    function deleteDosen(): void
    {
        $nip = $_POST['nip'];

        try {
            $this->adminService->deleteDosen($nip);
            echo json_encode(['status' => 'OK']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    function detailDosen(): void
    {
        $nip = $_POST['nip'];

        try {
            $dosen = $this->adminService->getDetailDosen($nip);
            echo json_encode([
                'status' => 'OK',
                'data' => $dosen
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}