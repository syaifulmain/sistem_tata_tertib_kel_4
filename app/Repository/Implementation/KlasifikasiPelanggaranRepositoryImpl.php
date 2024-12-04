<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\KlasifikasiPelanggaran;
use Kelompok2\SistemTataTertib\Domain\SanksiPelanggaran;
use Kelompok2\SistemTataTertib\Repository\KlasifikasiPelanggaranRepository;

class KlasifikasiPelanggaranRepositoryImpl implements KlasifikasiPelanggaranRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $query = "SELECT KP.klasifikasi_pelanggaran_id,
       KP.tingkat,
       KP.pelanggaran,
       SP.sanksi_pelanggaran_id,
       SP.sanksi
FROM Rules.KlasifikasiPelanggaran AS KP
         INNER JOIN Rules.SanksiPelanggaran SP on SP.sanksi_pelanggaran_id = KP.sanki_id";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = [];
        while ($row = $statement->fetch()) {
            $klasifikasiPelanggaran = new KlasifikasiPelanggaran();
            $klasifikasiPelanggaran->id = $row['klasifikasi_pelanggaran_id'];
            $klasifikasiPelanggaran->tingkat = $row['tingkat'];
            $klasifikasiPelanggaran->pelanggaran = $row['pelanggaran'];

            $saksiPelanggaran = new SanksiPelanggaran();
            $saksiPelanggaran->id = $row['sanksi_pelanggaran_id'];
            $saksiPelanggaran->tingkat = $row['tingkat'];
            $saksiPelanggaran->sanksi = $row['sanksi'];

            $klasifikasiPelanggaran->sanksi = $saksiPelanggaran;
            $result[] = $klasifikasiPelanggaran;
        }
        return $result;
    }
}