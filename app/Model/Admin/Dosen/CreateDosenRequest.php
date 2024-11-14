<?php

namespace Kelompok2\SistemTataTertib\Model\Admin\Dosen;

class CreateDosenRequest
{
    public ?string $nip = null;
    public ?string $nama = null;
    public ?string $no_telp = null;

    public ?string $email = null;

    public ?string $kelas = null;
}