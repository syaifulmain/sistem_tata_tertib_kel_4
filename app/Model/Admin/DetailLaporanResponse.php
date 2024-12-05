<?php

namespace Kelompok2\SistemTataTertib\Model\Admin;

class DetailLaporanResponse
{
    public string $nim;
    public string $namaPelanggar;
    public string $kelas;
    public string $tanggal;
    public string $namaPelapor;
    public string $pelanggaran;
    public int $tingkat;
    public string $sanksi;
    public string $bukti;
    public string $deskripsi;
    public string $verifikasi;
    public string $batal;

    /**
     * @param string $nim
     * @param string $namaPelanggar
     * @param string $kelas
     * @param string $tanggal
     * @param string $namaPelapor
     * @param string $pelanggaran
     * @param int $tingkat
     * @param string $sanksi
     * @param string $bukti
     * @param string $deskripsi
     * @param string $verifikasi
     * @param string $batal
     */
    public function __construct(string $nim, string $namaPelanggar, string $kelas, string $tanggal, string $namaPelapor, string $pelanggaran, int $tingkat, string $sanksi, string $bukti, string $deskripsi, string $verifikasi, string $batal)
    {
        $this->nim = $nim;
        $this->namaPelanggar = $namaPelanggar;
        $this->kelas = $kelas;
        $this->tanggal = $tanggal;
        $this->namaPelapor = $namaPelapor;
        $this->pelanggaran = $pelanggaran;
        $this->tingkat = $tingkat;
        $this->sanksi = $sanksi;
        $this->bukti = $bukti;
        $this->deskripsi = $deskripsi;
        $this->verifikasi = $verifikasi;
        $this->batal = $batal;
    }


}