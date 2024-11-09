<?php

namespace Kelompok2\SistemTataTertib\Model\User;

use Kelompok2\SistemTataTertib\Domain\User;

class CreateUserRequest
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $level = null;
}