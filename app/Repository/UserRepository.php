<?php

namespace Kelompok2\SistemTataTertib\Repository;

use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Model\User\UserUpdateRequest;

interface UserRepository
{
     function save(User $user): User;

     function update(UserUpdateRequest $request): bool;

     function findUserByUsername(string $username): ?User;

     function deleteAll(): void;
}