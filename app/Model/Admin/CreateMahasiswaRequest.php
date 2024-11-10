<?php

namespace Kelompok2\SistemTataTertib\Model\Admin;

class CreateMahasiswaRequest
{
    public ?string $nim = null;
    public ?string $nama = null;
    public ?string $no_telp = null;

    public ?string $email = null;

    public ?string $kelas = null;
}