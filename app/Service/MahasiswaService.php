<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Mahasiswa\DetailPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Mahasiswa\KirimSuratPernyataanRequest;

interface MahasiswaService
{
    function getAllPelanggaran(): array;

    function simpanSuratPernyataan(KirimSuratPernyataanRequest $request): void;

    function getDetailPelanggaran(int $id): DetailPelanggaranResponse;
}