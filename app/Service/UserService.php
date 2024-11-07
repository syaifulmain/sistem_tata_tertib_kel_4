<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\User\UserLoginRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginResponse;
use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaRequest;
use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaResponse;
use Kelompok2\SistemTataTertib\Model\User\UserUpdateRequest;

interface UserService
{
    function login(UserLoginRequest $request): UserLoginResponse;
}