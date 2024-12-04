<?php

namespace Kelompok2\SistemTataTertib\Model\Dosen;

class LaporMahasiswaRequest
{
    public ?int $mahasiswa_id;

    public ?string $nip;

    public ?string $tanggal;

    public ?int $klasifikasi_id;
    public ?string $deskripsi;
    public ?string $bukti;

    /**
     * @param string|null $nim
     * @param string|null $nip
     * @param string|null $tanggal
     * @param int|null $klasifikasi_id
     * @param string|null $deskripsi
     * @param string|null $bukti
     */
    public function __construct(?int $mahasiswa_id, ?string $nip, ?string $tanggal, ?int $klasifikasi_id, ?string $deskripsi, ?string $bukti)
    {
        $this->mahasiswa_id = $mahasiswa_id;
        $this->nip = $nip;
        $this->tanggal = $tanggal;
        $this->klasifikasi_id = $klasifikasi_id;
        $this->deskripsi = $deskripsi;
        $this->bukti = $bukti;
    }

}