<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Mahasisawa;

interface MahasiswaRepository
{
    function save(Mahasisawa $mahasiswa) : void;

    function findMahasiswaByNim(string $nim): ?Mahasisawa;

    function getIdByNim(string $nim) : ?int;

    function getAllMahasiswa() : array;
}