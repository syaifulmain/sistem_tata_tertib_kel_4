<?php

namespace Kelompok2\SistemTataTertib\Domain;

class Pelaporan
{
    public int $id;
    public Mahasisawa $mahasiswa;
    public Dosen $dosen;
    public string $tanggal_pelanggaran;
    public KlasifikasiPelanggaran $klasifikasiPelanggaran;
    public string $deskripsi;
    public string $bukti;
    public bool $verifikasi;
    public bool $batal;


}