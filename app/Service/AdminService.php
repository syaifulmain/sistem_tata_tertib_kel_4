<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanResponse;

interface AdminService
{
    function getAllLaporan(): array;

    function getDetailLaporan(int $id): DetailLaporanResponse;

    function kirimLaporan(int $id): void;

    function batalkanLaporan(int $id): void;

    function getAllLaporanPelanggaran(): array;

    function getDetailLaporanPelanggaran(int $id): DetailLaporanPelanggaranResponse;

    function bebasPelanggaran(int $id): void;
}