<?php

namespace Kelompok2\SistemTataTertib\Model\Mahasiswa;

class KirimSuratPernyataanRequest
{
    public int $id;
    public string $suratPernyataan;

    /**
     * @param int $id
     * @param string $suratPernyataan
     */
    public function __construct(int $id, string $suratPernyataan)
    {
        $this->id = $id;
        $this->suratPernyataan = $suratPernyataan;
    }


}