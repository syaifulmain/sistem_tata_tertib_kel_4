<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\Mahasisawa;
use Kelompok2\SistemTataTertib\Repository\MahasiswaRepository;

class MahasiswaRepositoryImpl implements MahasiswaRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
    function save(Mahasisawa $mahasiswa): void
    {
        $statement = $this->connection->prepare("INSERT INTO Core.Mahasiswa (nim, nama_lengkap, no_telepon, email) VALUES (:nim, :nama_lengkap, :no_telepon, :email)");
        $statement->bindParam("nim", $mahasiswa->nim);
        $statement->bindParam("nama_lengkap", $mahasiswa->nama_lengkap);
        $statement->bindParam("no_telepon", $mahasiswa->no_telepon);
        $statement->bindParam("email", $mahasiswa->email);
        $statement->execute();
    }

    function findMahasiswaByNim(string $nim): ?Mahasisawa
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap,no_telepon,email FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        $statement->execute();
        try {
            if ($row = $statement->fetch()) {
                $mahasiswa = new Mahasisawa();
                $mahasiswa->nim = $row['nim'];
                $mahasiswa->nama_lengkap = $row['nama_lengkap'];
                $mahasiswa->no_telepon = $row['no_telepon'];
                $mahasiswa->email = $row['email'];
                return $mahasiswa;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            $statement->closeCursor();
        }
    }

    function getIdByNim(string $nim): ?int
    {
        $statement = $this->connection->prepare("SELECT mahasiswa_id FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        $statement->execute();
        $result = $statement->fetch();
        return $result["mahasiswa_id"];
    }

    function getAllMahasiswa(): array
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap, no_telepon, email FROM Core.Mahasiswa");
        $statement->execute();
        $mahasiswas = [];
        while ($row = $statement->fetch()) {
            $mahasiswa = new Mahasisawa();
            $mahasiswa->nim = $row['nim'];
            $mahasiswa->nama_lengkap = $row['nama_lengkap'];
            $mahasiswa->no_telepon = $row['no_telepon'];
            $mahasiswa->email = $row['email'];
            $mahasiswas[] = $mahasiswa;
        }
        return $mahasiswas;
    }

    function deleteMahasiswaByNim(string $nim): void
    {
        $statement = $this->connection->prepare("DELETE FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        $statement->execute();
    }
}