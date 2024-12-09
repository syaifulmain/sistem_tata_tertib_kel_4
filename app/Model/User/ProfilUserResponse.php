<?php

namespace Kelompok2\SistemTataTertib\Model\User;

class ProfilUserResponse
{

    public ?string $nama;
    public ?string $username;
    public ?string $email;
    public ?string $noHp;
    public ?string $kelas;

    /**
     * @param string|null $nama
     * @param string|null $username
     * @param string|null $email
     * @param string|null $noHp
     * @param string|null $kelas
     */
    public function __construct(?string $nama, ?string $username, ?string $email, ?string $noHp, ?string $kelas)
    {
        $this->nama = $nama;
        $this->username = $username;
        $this->email = $email;
        $this->noHp = $noHp;
        $this->kelas = $kelas;
    }


}