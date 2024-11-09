<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\Session;

interface SessionRepository
{
    function save(Session $session): void;

    function findBySessionToken(string $sessionToken): ?Session;

    function deleteBySessionToken(string $sessionToken): void;

    function deleteByUserId(int $userId): void;

    function deleteAll(): void;
}