<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\Mahasisawa;
use Kelompok2\SistemTataTertib\Model\Admin\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\DetailMahasiswaResponse;
use Kelompok2\SistemTataTertib\Repository\KelasRepository;
use Kelompok2\SistemTataTertib\Repository\MahasiswaRepository;
use Kelompok2\SistemTataTertib\Repository\TIRepository;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\AdminService;

class AdminServiceImpl implements AdminService
{
    private MahasiswaRepository $mahasiswaRepository;

    private KelasRepository $kelasRepository;

    private TIRepository $tiRepository;

    private UserRepository $userRepository;

    public function __construct(
        MahasiswaRepository $mahasiswaRepository,
        KelasRepository     $kelasRepository,
        TIRepository        $tiRepository,
        UserRepository      $userRepository)
    {
        $this->mahasiswaRepository = $mahasiswaRepository;
        $this->kelasRepository = $kelasRepository;
        $this->tiRepository = $tiRepository;
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
            $this->mahasiswaRepository->save($mahasiswa);



            $kelasId = $this->kelasRepository->getKelasIdByKelas($request->kelas);
            $mahasiswaId = $this->mahasiswaRepository->getIdByNim($request->nim);
            $this->tiRepository->save($mahasiswaId, $kelasId);
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

        $mahasiswaId = $this->mahasiswaRepository->getIdByNim($nim);
        $kelasId = $this->tiRepository->getKelasIdByMahasiswaId($mahasiswaId);
        $response = new DetailMahasiswaResponse();
        $response->nim = $mahasiswa->nim;
        $response->nama_lengkap = $mahasiswa->nama_lengkap;
        $response->no_telepon = $mahasiswa->no_telepon;
        $response->email = $mahasiswa->email;
        $response->kelas = $this->kelasRepository->getKelasByKelasId($kelasId)->kelas;

        $user = $this->userRepository->findUserByUsername($nim);
        $response->password = $user->password;

        return $response;
    }

    function deleteMahasiswaByNim(string $nim): void
    {
        // TODO: Implement deleteMahasiswaByNim() method.
    }
}