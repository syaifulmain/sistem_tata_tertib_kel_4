<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaRequest;
use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaResponse;
use Kelompok2\SistemTataTertib\Model\User\UserUpdateRequest;

interface UserService
{
    function registerMahasiwaUser(UserRegisterMahasiwaRequest $request): UserRegisterMahasiwaResponse;

    function updateUserPassword(UserUpdateRequest $request): bool;
}