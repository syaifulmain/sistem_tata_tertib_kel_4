<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\Mahasisawa;
use Kelompok2\SistemTataTertib\Model\Admin\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\DetailMahasiswaResponse;
use Kelompok2\SistemTataTertib\Repository\KelasRepository;
use Kelompok2\SistemTataTertib\Repository\MahasiswaRepository;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\AdminService;

class AdminServiceImpl implements AdminService
{
    private MahasiswaRepository $mahasiswaRepository;

    private KelasRepository $kelasRepository;

    private UserRepository $userRepository;

    public function __construct(
        MahasiswaRepository $mahasiswaRepository,
        KelasRepository $kelasRepository,
        UserRepository      $userRepository)
    {
        $this->mahasiswaRepository = $mahasiswaRepository;
        $this->kelasRepository = $kelasRepository;
        $this->userRepository = $userRepository;
    }


    function createMahasiswa(CreateMahasiswaRequest $request): void
    {
        if ($request->nim === null || trim($request->nim) === "") {
            throw new \Exception("NIM tidak boleh kosong");
        }

        if ($request->nama === null || trim($request->nama) === "") {
            throw new \Exception("Nama tidak boleh kosong");
        }

        if ($request->kelas === null || trim($request->kelas) === "") {
            throw new \Exception("Kelas tidak boleh kosong");
        }

        $mahasiswa = $this->mahasiswaRepository->findMahasiswaByNim($request->nim);

        if ($mahasiswa !== null) {
            throw new \Exception("NIM sudah digunakan");
        }

        try {
            $log = fopen("log.txt", "a");
            Database::beginTransaction();
            $mahasiswa = new Mahasisawa();
            $mahasiswa->nim = $request->nim;
            $mahasiswa->nama_lengkap = $request->nama;
            $mahasiswa->no_telepon = $request->no_telp;
            $mahasiswa->email = $request->email;
            $mahasiswa->kelas = $request->kelas;
            $this->mahasiswaRepository->save($mahasiswa);

            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            fwrite($log, $exception->getMessage());
            throw new \Exception("Gagal Menyimpan Data Mahasiswa");
        }
    }

    function getAllMahasiswa(): array
    {
        return $this->mahasiswaRepository->getAllMahasiswa();
    }

    function getDetailMahasiswa(string $nim): ?DetailMahasiswaResponse
    {
        $mahasiswa = $this->mahasiswaRepository->findMahasiswaByNim($nim);
        if ($mahasiswa === null) {
            throw new \Exception("Mahasiswa tidak ditemukan");
        }

        $response = new DetailMahasiswaResponse();
        $response->nim = $mahasiswa->nim;
        $response->nama_lengkap = $mahasiswa->nama_lengkap;
        $response->no_telepon = $mahasiswa->no_telepon;
        $response->email = $mahasiswa->email;
        $response->kelas = $mahasiswa->kelas;

        $user = $this->userRepository->findUserByUsername($nim);
        $response->username = $user->username;
        $response->password = $user->password;

        return $response;
    }

    function deleteMahasiswa(string $nim): void
    {
        if ($nim === null || trim($nim) === "") {
            throw new \Exception("NIM tidak boleh kosong");
        }

        $mahasiswa = $this->mahasiswaRepository->findMahasiswaByNim($nim);
        if ($mahasiswa === null) {
            throw new \Exception("Mahasiswa tidak ditemukan");
        }

        try {
            Database::beginTransaction();
            $this->mahasiswaRepository->deleteMahasiswaByNim($nim);
            $this->userRepository->deleteUserByUsername($nim);
            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw new \Exception("Gagal Menghapus Data Mahasiswa");
        }
    }

    function getAllKelas(): array
    {
        return $this->kelasRepository->getAllKelas();
    }
}