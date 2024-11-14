<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Admin\Dosen\CreateDosenRequest;
use Kelompok2\SistemTataTertib\Model\Admin\Dosen\DetailDosenResponse;
use Kelompok2\SistemTataTertib\Model\Admin\Mahasiswa\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\Mahasiswa\DetailMahasiswaResponse;

interface AdminService
{
    function createMahasiswa(CreateMahasiswaRequest $request): void;

    function getAllMahasiswa(): array;

    function getDetailMahasiswa(string $nim): ?DetailMahasiswaResponse;

    function deleteMahasiswa(string $nim): void;

    function getAllKelas(): array;

    function createDoesn(CreateDosenRequest $request): void;

    function getAllDosen(): array;

    function getDetailDosen(string $nip): ?DetailDosenResponse;

    function deleteDosen(string $nip): void;
}