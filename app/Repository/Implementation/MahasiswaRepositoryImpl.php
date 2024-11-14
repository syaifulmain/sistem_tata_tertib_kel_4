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
        $statement = $this->connection->prepare("INSERT INTO Core.Mahasiswa (nim, nama_lengkap, no_telepon, email, kelas) VALUES (:nim, :nama_lengkap, :no_telepon, :email, :kelas)");
        $statement->bindParam("nim", $mahasiswa->nim);
        $statement->bindParam("nama_lengkap", $mahasiswa->nama_lengkap);
        $statement->bindParam("no_telepon", $mahasiswa->no_telepon);
        $statement->bindParam("email", $mahasiswa->email);
        $statement->bindParam("kelas", $mahasiswa->kelas);
        $statement->execute();
    }

    function findMahasiswaByNim(string $nim): ?Mahasisawa
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap,no_telepon,email,kelas FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        $statement->execute();
        try {
            if ($row = $statement->fetch()) {
                $mahasiswa = new Mahasisawa();
                $mahasiswa->nim = $row['nim'];
                $mahasiswa->nama_lengkap = $row['nama_lengkap'];
                $mahasiswa->no_telepon = $row['no_telepon'];
                $mahasiswa->email = $row['email'];
                $mahasiswa->kelas = $row['kelas'];
                return $mahasiswa;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            $statement->closeCursor();
            return null;
        }
    }

    function getAllMahasiswa(): array
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap, no_telepon, email,kelas FROM Core.Mahasiswa");
        $statement->execute();
        $mahasiswas = [];
        while ($row = $statement->fetch()) {
            $mahasiswa = new Mahasisawa();
            $mahasiswa->nim = $row['nim'];
            $mahasiswa->nama_lengkap = $row['nama_lengkap'];
            $mahasiswa->no_telepon = $row['no_telepon'];
            $mahasiswa->email = $row['email'];
            $mahasiswa->kelas = $row['kelas'];
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