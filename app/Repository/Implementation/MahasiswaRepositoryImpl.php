<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\Mahasisawa;
use Kelompok2\SistemTataTertib\Repository\MahasisawaRepository;

class MahasiswaRepositoryImpl implements MahasisawaRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Mahasisawa $mahasisawa): bool
    {
        $statement = $this->connection->prepare("INSERT INTO Core.Mahasiswa (nim, nama_lengkap, nik, kota_lahir, tanggal_lahir, agama, jenis_kelamin, golongan_darah, anak_ke, no_telepon, email) VALUES (:nim, :nama_lengkap, :nik, :kota_lahir, :tanggal_lahir, :agama, :jenis_kelamin, :golongan_darah, :anak_ke, :no_telepon, :email)");
        $statement->bindParam("nim", $mahasisawa->nim);
        $statement->bindParam("nama_lengkap", $mahasisawa->nama_lengkap);
        $statement->bindParam("nik", $mahasisawa->nik);
        $statement->bindParam("kota_lahir", $mahasisawa->kota_lahir);
        $statement->bindParam("tanggal_lahir", $mahasisawa->tanggal_lahir);
        $statement->bindParam("agama", $mahasisawa->agama);
        $statement->bindParam("jenis_kelamin", $mahasisawa->jenis_kelamin);
        $statement->bindParam("golongan_darah", $mahasisawa->golongan_darah);
        $statement->bindParam("anak_ke", $mahasisawa->anak_ke);
        $statement->bindParam("no_telepon", $mahasisawa->no_telepon);
        $statement->bindParam("email", $mahasisawa->email);
        return $statement->execute();
    }

    public function update(Mahasisawa $mahasisawa): bool
    {
        $statement = $this->connection->prepare("UPDATE Core.Mahasiswa SET nama_lengkap = :nama_lengkap, nik = :nik, kota_lahir = :kota_lahir, tanggal_lahir = :tanggal_lahir, agama = :agama, jenis_kelamin = :jenis_kelamin, golongan_darah = :golongan_darah, anak_ke = :anak_ke, no_telepon = :no_telepon, email = :email, updated_at = :updated_at WHERE nim = :nim");
        $statement->bindParam("nim", $mahasisawa->nim);
        $statement->bindParam("nama_lengkap", $mahasisawa->nama_lengkap);
        $statement->bindParam("nik", $mahasisawa->nik);
        $statement->bindParam("kota_lahir", $mahasisawa->kota_lahir);
        $statement->bindParam("tanggal_lahir", $mahasisawa->tanggal_lahir);
        $statement->bindParam("agama", $mahasisawa->agama);
        $statement->bindParam("jenis_kelamin", $mahasisawa->jenis_kelamin);
        $statement->bindParam("golongan_darah", $mahasisawa->golongan_darah);
        $statement->bindParam("anak_ke", $mahasisawa->anak_ke);
        $statement->bindParam("no_telepon", $mahasisawa->no_telepon);
        $statement->bindParam("email", $mahasisawa->email);
        $statement->bindParam("updated_at", $mahasisawa->updated_at);
        return $statement->execute();
    }

    public function getMahasiswa(): array
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap, nik, kota_lahir, tanggal_lahir, agama, jenis_kelamin, golongan_darah, anak_ke, no_telepon, email, created_at,updated_at  FROM Core.Mahasiswa");
        $statement->execute();
        $mahasisawa = [];
        while ($row = $statement->fetch()) {
            $mahasiwa = $this->getMahasisawaData($row);
            $mahasisawa[] = $mahasiwa;
        }
        return $mahasisawa;
    }

    public function getMahasiswaByNim(string $nim): ?Mahasisawa
    {
        $statement = $this->connection->prepare("SELECT nim, nama_lengkap, nik, kota_lahir, tanggal_lahir, agama, jenis_kelamin, golongan_darah, anak_ke, no_telepon, email, created_at,updated_at  FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        $statement->execute();
        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }
        return $this->getMahasisawaData($row);
    }

    public function delete(string $nim): bool
    {
        $statement = $this->connection->prepare("DELETE FROM Core.Mahasiswa WHERE nim = :nim");
        $statement->bindParam("nim", $nim);
        return $statement->execute();
    }

    public function deleteAll(): bool
    {
        $statement = $this->connection->prepare("DELETE FROM Core.Mahasiswa");
        return $statement->execute();
    }

    /**
     * @param mixed $row
     * @return Mahasisawa
     */
    private function getMahasisawaData(mixed $row): Mahasisawa
    {
        $mahasiwa = new Mahasisawa();
        $mahasiwa->nim = $row["nim"];
        $mahasiwa->nama_lengkap = $row["nama_lengkap"];
        $mahasiwa->nik = $row["nik"];
        $mahasiwa->kota_lahir = $row["kota_lahir"];
        $mahasiwa->tanggal_lahir = $row["tanggal_lahir"];
        $mahasiwa->agama = $row["agama"];
        $mahasiwa->jenis_kelamin = $row["jenis_kelamin"];
        $mahasiwa->golongan_darah = $row["golongan_darah"];
        $mahasiwa->anak_ke = $row["anak_ke"];
        $mahasiwa->no_telepon = $row["no_telepon"];
        $mahasiwa->email = $row["email"];
        $mahasiwa->created_at = $row["created_at"];
        $mahasiwa->updated_at = $row["updated_at"];
        return $mahasiwa;
    }
}