<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Domain\Session;
use Kelompok2\SistemTataTertib\Domain\User;

interface SessionService
{
    function create(int $user_id): Session;

    function destroy();

    function current(): ?User;

}