<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\User\ProfilUserResponse;

interface CurrentUserService
{
    function getUsernameAndName(string $username): void;

    function getInfoUser(string $username): ProfilUserResponse;
}