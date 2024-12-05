<?php

namespace Kelompok2\SistemTataTertib\Model\Mahasiswa;

class PelanggaranMahasiswaResponse
{

    public int $id;

    public string $pelanggaran;

    public int $tingkat;

    public string $tanggal;

    public bool $status;
    public bool $kirimDokumenStatus;

    /**
     * @param int $id
     * @param string $pelanggaran
     * @param int $tingkat
     * @param string $tanggal
     * @param bool $status
     * @param bool $kirimDokumenStatus
     */
    public function __construct(int $id, string $pelanggaran, int $tingkat, string $tanggal, bool $status, bool $kirimDokumenStatus)
    {
        $this->id = $id;
        $this->pelanggaran = $pelanggaran;
        $this->tingkat = $tingkat;
        $this->tanggal = $tanggal;
        $this->status = $status;
        $this->kirimDokumenStatus = $kirimDokumenStatus;
    }


}