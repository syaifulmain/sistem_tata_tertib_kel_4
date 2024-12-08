<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\DetailRiwayatLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\LaporMahasiswaRequest;

interface DosenService
{
    function getALlKlasifikasi(): array;

    function getAllMahasiswa(): array;

    function getCurrentUsername(): string;

    function getDetailRiwayatLaporan(int $id): DetailRiwayatLaporanResponse;

//    dosen
    function laporMahasiwa(LaporMahasiswaRequest $request): void;

    function getAllRiwayatLaporMahasiswaCurrentDosen(): array;

//    dosen dpa

    function getAllLaporan(): array;

    function getDetailLaporan(int $id): DetailLaporanResponse;

//    dosen admin
}