<?php

namespace Kelompok2\SistemTataTertib\Model\Mahasiswa;

class DetailPelanggaranResponse
{
    public ?string $nama;
    public ?string $nim;
    public ?string $kelas;
    public ?string $tanggal;
    public ?string $pelanggaran;
    public ?int $tingkat;
    public ?string $sanksi;
    public ?string $bukti;
    public ?string $deskripsi;
    public ?string $suratPernyataan;
    public ?bool $status;

    /**
     * @param string|null $nama
     * @param string|null $nim
     * @param string|null $kelas
     * @param string|null $tanggal
     * @param string|null $pelanggaran
     * @param int|null $tingkat
     * @param string|null $sanksi
     * @param string|null $bukti
     * @param string|null $deskripsi
     * @param string|null $suratPernyataan
     * @param bool|null $status
     */
    public function __construct(?string $nama, ?string $nim, ?string $kelas, ?string $tanggal, ?string $pelanggaran, ?int $tingkat, ?string $sanksi, ?string $bukti, ?string $deskripsi, ?string $suratPernyataan, ?bool $status)
    {
        $this->nama = $nama;
        $this->nim = $nim;
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