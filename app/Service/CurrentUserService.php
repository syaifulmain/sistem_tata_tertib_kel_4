<?php

namespace Kelompok2\SistemTataTertib\Service;

interface CurrentUserService
{
    function getUsernameAndName(string $username): void;
}