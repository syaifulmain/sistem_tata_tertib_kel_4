<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Kelas;

interface KelasRepository
{
    function getAllKelas(): array;

    function getKelasIdByKelas(string $kelas): ?int;

    function getKelasByKelasId(string $kelasId): ?Kelas;
}