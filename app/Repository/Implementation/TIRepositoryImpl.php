<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Repository\TIRepository;

class TIRepositoryImpl implements TIRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
    function save(int $mahasiswaId, int $kelasId): void
    {
        $statement = $this->connection->prepare("INSERT INTO Core.TeknologiInformasi (mahasiswa_id, kelas_id) VALUES (:mahasiswaId, :kelasId)");
        $statement->bindParam(":mahasiswaId", $mahasiswaId);
        $statement->bindParam(":kelasId", $kelasId);
        $statement->execute();
    }

    function getKelasIdByMahasiswaId(int $mahasiswaId): ?int
    {
        $statement = $this->connection->prepare("SELECT kelas_id FROM Core.TeknologiInformasi WHERE mahasiswa_id = :mahasiswaId");
        $statement->bindParam(":mahasiswaId", $mahasiswaId);
        $statement->execute();
        $result = $statement->fetch();
        return $result["kelas_id"];
    }
}