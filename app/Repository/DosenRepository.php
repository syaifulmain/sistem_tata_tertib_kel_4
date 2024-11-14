<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Dosen;

interface DosenRepository
{
    function save(Dosen $dosen) : void;

    function findDosenByNip(string $nip): ?Dosen;

    function getAllDosen() : array;

    function deleteDosenByNip(string $nip) : void;
}