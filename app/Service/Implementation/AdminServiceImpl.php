<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\Dosen;
use Kelompok2\SistemTataTertib\Domain\Mahasisawa;
use Kelompok2\SistemTataTertib\Model\Admin\Dosen\CreateDosenRequest;
use Kelompok2\SistemTataTertib\Model\Admin\Dosen\DetailDosenResponse;
use Kelompok2\SistemTataTertib\Model\Admin\Mahasiswa\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\Mahasiswa\DetailMahasiswaResponse;
use Kelompok2\SistemTataTertib\Repository\DosenRepository;
use Kelompok2\SistemTataTertib\Repository\KelasRepository;
use Kelompok2\SistemTataTertib\Repository\MahasiswaRepository;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\AdminService;

class AdminServiceImpl implements AdminService
{
    private MahasiswaRepository $mahasiswaRepository;
    private DosenRepository $dosenRepository;

    private KelasRepository $kelasRepository;

    private UserRepository $userRepository;

    public function __construct(
        MahasiswaRepository $mahasiswaRepository,
        DosenRepository $dosenRepository,
        KelasRepository $kelasRepository,
        UserRepository      $userRepository)
    {
        $this->mahasiswaRepository = $mahasiswaRepository;
        $this->dosenRepository = $dosenRepository;
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
            throw new \Exception("Gagal Menyimpan Data Mahasiswa");
        }
    }

    function getAllMahasiswa(): array
    {
        try {
            return $this->mahasiswaRepository->getAllMahasiswa();
        } catch (\Exception $exception) {
            throw new \Exception("Gagal Mengambil Data Mahasiswa");
        }
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

        try {
            return $response;
        } catch (\Exception $exception) {
            throw new \Exception("Gagal Mengambil Data Mahasiswa");
        }
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
        try {
            return $this->kelasRepository->getAllKelas();
        } catch (\Exception $exception) {
            throw new \Exception("Gagal Mengambil Data Kelas");
        }
    }

    function createDoesn(CreateDosenRequest $request): void
    {
        if ($request->nip === null || trim($request->nip) === "") {
            throw new \Exception("NIP tidak boleh kosong");
        }

        if ($request->nama === null || trim($request->nama) === "") {
            throw new \Exception("Nama tidak boleh kosong");
        }

        $dosen = $this->dosenRepository->findDosenByNip($request->nip);

        if ($dosen !== null) {
            throw new \Exception("NIP sudah digunakan");
        }

        try {
            Database::beginTransaction();
            $dosen = new Dosen();
            $dosen->nip = $request->nip;
            $dosen->nama_lengkap = $request->nama;
            $dosen->no_telepon = $request->no_telp;
            $dosen->email = $request->email;
            $dosen->kelas = $request->kelas;
            $this->dosenRepository->save($dosen);

            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw new \Exception("Gagal Menyimpan Data Dosen");
        }
    }

    function getAllDosen(): array
    {
        try {
            return $this->dosenRepository->getAllDosen();
        } catch (\Exception $exception) {
            throw new \Exception("Gagal Mengambil Data Dosen");
        }
    }

    function getDetailDosen(string $nip): ?DetailDosenResponse
    {
        $dosen = $this->dosenRepository->findDosenByNip($nip);
        if ($dosen === null) {
            throw new \Exception("Dosen tidak ditemukan");
        }

        $response = new DetailDosenResponse();
        $response->nip = $dosen->nip;
        $response->nama_lengkap = $dosen->nama_lengkap;
        $response->no_telepon = $dosen->no_telepon;
        $response->email = $dosen->email;
        $response->kelas = $dosen->kelas;

        $user = $this->userRepository->findUserByUsername($nip);
        $response->username = $user->username;
        $response->password = $user->password;

        try {
            return $response;
        } catch (\Exception $exception) {
            throw new \Exception("Gagal Mengambil Data Dosen");
        }
    }

    function deleteDosen(string $nip): void
    {
        if ($nip === null || trim($nip) === "") {
            throw new \Exception("NIP tidak boleh kosong");
        }

        $dosen = $this->dosenRepository->findDosenByNip($nip);
        if ($dosen === null) {
            throw new \Exception("Dosen tidak ditemukan");
        }

        try {
            Database::beginTransaction();
            $this->dosenRepository->deleteDosenByNip($nip);
            $this->userRepository->deleteUserByUsername($nip);
            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw new \Exception("Gagal Menghapus Data Dosen");
        }
    }
}