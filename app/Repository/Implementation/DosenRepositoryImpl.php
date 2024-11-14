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
    function save(Dosen $dosen): void
    {
        $statement = $this->connection->prepare("INSERT INTO Core.Dosen (nip, nama_lengkap, no_telepon, email, kelas) VALUES (:nip, :nama_lengkap, :no_telepon, :email, :kelas)");
        $statement->bindParam("nip", $dosen->nip);
        $statement->bindParam("nama_lengkap", $dosen->nama_lengkap);
        $statement->bindParam("no_telepon", $dosen->no_telepon);
        $statement->bindParam("email", $dosen->email);
        $statement->bindParam("kelas", $dosen->kelas);
        $statement->execute();
    }

    function findDosenByNip(string $nip): ?Dosen
    {
        $statement = $this->connection->prepare("SELECT nip, nama_lengkap,no_telepon,email,kelas FROM Core.Dosen WHERE nip = :nip");
        $statement->bindParam("nip", $nip);
        $statement->execute();
        try {
            if ($row = $statement->fetch()) {
                $dosen = new Dosen();
                $dosen->nip = $row['nip'];
                $dosen->nama_lengkap = $row['nama_lengkap'];
                $dosen->no_telepon = $row['no_telepon'];
                $dosen->email = $row['email'];
                $dosen->kelas = $row['kelas'];
                return $dosen;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            $statement->closeCursor();
            return null;
        }
    }

    function getAllDosen(): array
    {
        $statement = $this->connection->prepare("SELECT nip, nama_lengkap, no_telepon, email,kelas FROM Core.Dosen");
        $statement->execute();
        $dosens = [];
        while ($row = $statement->fetch()) {
            $dosen = new Dosen();
            $dosen->nip = $row['nip'];
            $dosen->nama_lengkap = $row['nama_lengkap'];
            $dosen->no_telepon = $row['no_telepon'];
            $dosen->email = $row['email'];
            $dosen->kelas = $row['kelas'];
            $dosens[] = $dosen;
        }
        return $dosens;
    }

    function deleteDosenByNip(string $nip): void
    {
        $statement = $this->connection->prepare("DELETE FROM Core.Dosen WHERE nip = :nip");
        $statement->bindParam("nip", $nip);
        $statement->execute();
    }
}