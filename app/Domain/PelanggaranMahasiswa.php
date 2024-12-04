<?php

namespace Kelompok2\SistemTataTertib\Domain;

class PelanggaranMahasiswa
{
    public int $id;
    public Pelaporan $pelaporan;
    public bool $status;
    public string $surat_pernyataan;
    public string $bukti_bebas_pelanggaran;
}