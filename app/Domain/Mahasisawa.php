<?php

namespace Kelompok2\SistemTataTertib\Domain;

class Mahasisawa
{
    public int $id;
    public string $nim;
    public string $nama_lengkap;
    public string $no_telepon;
    public string $email;
    public Prodi $prodi;
    public Kelas $kelas;
}