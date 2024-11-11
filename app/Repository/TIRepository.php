<?php

namespace Kelompok2\SistemTataTertib\Repository;

interface TIRepository
{
    function save(int $mahasiswaId, int $kelasId): void;

    function getKelasIdByMahasiswaId(int $mahasiswaId): ?int;

    function deleteByMahasiswaId(int $mahasiswaId): void;
}