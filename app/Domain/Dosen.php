<?php

namespace Kelompok2\SistemTataTertib\Domain;

class Dosen
{
    public int $id;
    public string $nip;
    public string $nama_lengkap;
    public string $no_telepon;
    public string $email;
    public bool $is_admin;
    public bool $is_dpa;
}