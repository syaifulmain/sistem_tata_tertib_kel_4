<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Domain\Session;
use Kelompok2\SistemTataTertib\Domain\User;

interface SessionService
{
    function create(string $username): void;

    function destroy(): void;

    function current(): ?User;

    function cantLoginMultipleDevice(string $username): void;

}