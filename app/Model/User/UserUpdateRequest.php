<?php

namespace Kelompok2\SistemTataTertib\Model\User;

class UserUpdateRequest
{
    public ?string $username = null;
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
    public ?string $updated_at = null;
}