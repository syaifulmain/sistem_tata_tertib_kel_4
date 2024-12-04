<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\Dosen;
use Kelompok2\SistemTataTertib\Repository\DosenRepository;

class DosenRepositoryImpl implements DosenRepository
{

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
}