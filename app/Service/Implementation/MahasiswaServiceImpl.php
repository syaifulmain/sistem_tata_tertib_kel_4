<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Exception\ValidationException;
use Kelompok2\SistemTataTertib\Model\Mahasiswa\MahasiswaDataResponse;
use Kelompok2\SistemTataTertib\Repository\MahasisawaRepository;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaServiceImpl implements MahasiswaService
{
    private MahasisawaRepository $mahasiswaRepository;

    public function __construct(MahasisawaRepository $mahasiswaRepository)
    {
        $this->mahasiswaRepository = $mahasiswaRepository;
    }


    function updateMahasiswa()
    {
        // TODO: Implement updateMahasiswa() method.
    }

    function getMahasiswa(string $nim): MahasiswaDataResponse
    {
        $mahasiswa = $this->mahasiswaRepository->getMahasiswaByNim($nim);

        if ($mahasiswa == null) {
            throw new ValidationException("Data Mahasiswa not found");
        }

        $response = new MahasiswaDataResponse();

        $response->nama_lengkap = $mahasiswa->nama_lengkap;
        $response->nik = $mahasiswa->nik;
        $response->kota_lahir = $mahasiswa->kota_lahir;
        $response->tanggal_lahir = $mahasiswa->tanggal_lahir;
        $response->agama = $mahasiswa->agama;
        $response->jenis_kelamin = $mahasiswa->jenis_kelamin;
        $response->golongan_darah = $mahasiswa->golongan_darah;
        $response->anak_ke = $mahasiswa->anak_ke;
        $response->no_telepon = $mahasiswa->no_telepon;
        $response->email = $mahasiswa->email;

        return $response;
    }

    function uploadSanctionDocument()
    {
        // TODO: Implement uploadSanctionDocument() method.
    }
}