<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Dosen\DetailRiwayatLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\LaporMahasiswaRequest;

interface DosenService
{
    function getALlKlasifikasi(): array;

    function getAllMahasiswa(): array;

    function getCurrentUsername(): string;

    function getDetailLaporan(int $id): DetailRiwayatLaporanResponse;

//    dosen
    function laporMahasiwa(LaporMahasiswaRequest $request): void;

    function getAllRiwayatLaporMahasiswaCurrentDosen(): array;

//    dosen dpa

//    dosen admin
}