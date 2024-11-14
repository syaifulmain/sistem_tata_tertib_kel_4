<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Mahasisawa;

interface MahasiswaRepository
{
    function save(Mahasisawa $mahasiswa) : void;

    function findMahasiswaByNim(string $nim): ?Mahasisawa;

    function getAllMahasiswa() : array;

    function deleteMahasiswaByNim(string $nim) : void;
}