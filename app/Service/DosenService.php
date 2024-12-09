<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanPelanggaranResponse;
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

    function kirimLaporan(int $id): void;

    function getAllLaporan(): array;

    function getDetailLaporan(int $id): DetailLaporanResponse;

    function getListPelanggaranMahasiswa(): array;

    function getDetailPelanggaranMahasiswa(int $id): DetailLaporanPelanggaranResponse;

//    dosen admin
}