<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\Kelas;
use Kelompok2\SistemTataTertib\Repository\KelasRepository;

class KelasRepositoryImpl implements KelasRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function getAllKelas(): array
    {
        $statement = $this->connection->prepare("SELECT kelas FROM Core.Kelas");
        $statement->execute();

        $results = [];
        while ($row = $statement->fetch()) {
            $kelas = new Kelas();
            $kelas->kelas = $row['kelas'];
            $results[] = $kelas;
        }
        return $results;
    }

    function getKelasIdByKelas(string $kelas): ?int
    {
        $statement = $this->connection->prepare("SELECT kelas_id FROM Core.Kelas WHERE kelas = :kelas");
        $statement->bindParam(':kelas', $kelas);
        $statement->execute();
        $result = $statement->fetch();
        return $result['kelas_id'];
    }

    function getKelasByKelasId(string $kelasId): ?Kelas
    {
        $statement = $this->connection->prepare("SELECT kelas FROM Core.Kelas WHERE kelas_id = :kelasId");
        $statement->bindParam(':kelasId', $kelasId);
        $statement->execute();
        $result = $statement->fetch();
        $kelas = new Kelas();
        $kelas->kelas = $result['kelas'];
        return $kelas;
    }
}