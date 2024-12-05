<?php

namespace Kelompok2\SistemTataTertib\Model\Dosen;

class LaporMahasiswaRequest
{
    public ?int $nim;

    public ?int $nip;

    public ?string $tanggal;

    public ?int $klasifikasi_id;
    public ?string $deskripsi;
    public ?string $bukti;

    public function __construct(?int $nim, ?int $nip, ?string $tanggal, ?int $klasifikasi_id, ?string $deskripsi, ?string $bukti)
    {
        $this->nim = $nim;
        $this->nip = $nip;
        $this->tanggal = $tanggal;
        $this->klasifikasi_id = $klasifikasi_id;
        $this->deskripsi = $deskripsi;
        $this->bukti = $bukti;
    }

}