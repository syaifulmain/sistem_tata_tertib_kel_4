<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Admin\CreateMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Admin\DetailMahasiswaResponse;

interface AdminService
{
    function createMahasiswa(CreateMahasiswaRequest $request): void;

    function getAllMahasiswa(): array;

    function getDetailMahasiswa(string $nim): ?DetailMahasiswaResponse;

    function deleteMahasiswa(string $nim): void;
}