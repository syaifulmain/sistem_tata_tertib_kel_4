<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\User\CreateUserRequest;
use Kelompok2\SistemTataTertib\Model\User\UpdateUserRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginResponse;

interface UserService
{
    function createUser(CreateUserRequest $request): void;

    function updateUser(UpdateUserRequest $request): bool;

    function login(UserLoginRequest $request): UserLoginResponse;
}