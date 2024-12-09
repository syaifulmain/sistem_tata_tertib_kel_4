<?php

namespace Kelompok2\SistemTataTertib\Model;

class KlasifikasiPelanggaranResponse
{

    public string $pelanggaran;
    public int $tingkat;

    /**
     * @param string $pelanggaran
     * @param int $tingkat
     */
    public function __construct(string $pelanggaran, int $tingkat)
    {
        $this->pelanggaran = $pelanggaran;
        $this->tingkat = $tingkat;
    }


}