<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Mahasisawa;

interface MahasisawaRepository
{
    function save(Mahasisawa $mahasisawa): bool;

    function update(Mahasisawa $mahasisawa): bool;

    function getMahasiswa(): array;

    function getMahasiswaByNim(string $nim): ?Mahasisawa;

    function deleteMahasiswaByNim(string $nim): bool;

    function deleteAll(): bool;
}