<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\User;

interface UserRepository
{
    function save(User $user): void;

    function findUserByUsername(string $username): ?User;

    function findUserById(int $id): ?User;

    function deleteAll(): void;

    function deleteUserByUsername(string $username): void;
}