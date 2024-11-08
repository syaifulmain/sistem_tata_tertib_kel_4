<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Session;

interface SessionRepository
{
    function save(Session $session): Session;

    function findById(string $id): ?Session;

    function deleteById(string $id): void;
}