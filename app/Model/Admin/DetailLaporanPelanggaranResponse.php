<?php

namespace Kelompok2\SistemTataTertib\Model\Admin;

class DetailLaporanPelanggaranResponse
{
    public string $nim;
    public string $namaPelanggar;
    public string $kelas;
    public string $tanggal;
    public string $pelanggaran;
    public int $tingkat;
    public string $sanksi;
    public string $bukti;
    public string $deskripsi;
    public ?string $suratPernyataan = null;
    public ?bool $status = null;

    /**
     * @param string $nim
     * @param string $namaPelanggar
     * @param string $kelas
     * @param string $tanggal
     * @param string $pelanggaran
     * @param int $tingkat
     * @param string $sanksi
     * @param string $bukti
     * @param string $deskripsi
     * @param string|null $suratPernyataan
     * @param bool|null $status
     */
    public function __construct(string $nim, string $namaPelanggar, string $kelas, string $tanggal, string $pelanggaran, int $tingkat, string $sanksi, string $bukti, string $deskripsi, ?string $suratPernyataan, ?bool $status)
    {
        $this->nim = $nim;
        $this->namaPelanggar = $namaPelanggar;
        $this->kelas = $kelas;
        $this->tanggal = $tanggal;
        $this->pelanggaran = $pelanggaran;
        $this->tingkat = $tingkat;
        $this->sanksi = $sanksi;
        $this->bukti = $bukti;
        $this->deskripsi = $deskripsi;
        $this->suratPernyataan = $suratPernyataan;
        $this->status = $status;
    }


}