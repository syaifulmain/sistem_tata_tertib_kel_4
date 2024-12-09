<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Model\KlasifikasiPelanggaranResponse;
use Kelompok2\SistemTataTertib\Service\PelanggaranService;

class PelanggaranServiceImpl implements PelanggaranService
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
    function getAllKlasifikasi(): array
    {
        $query = "
        SELECT pelanggaran, tingkat FROM Rules.KlasifikasiPelanggaran
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = [];

            while ($row = $statement->fetch()) {
                $klasifikasi = new KlasifikasiPelanggaranResponse(
                    pelanggaran: $row['pelanggaran'],
                    tingkat: $row['tingkat']
                );
                $result[] = $klasifikasi;
            }

            return $result;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}