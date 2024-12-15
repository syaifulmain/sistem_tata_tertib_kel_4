<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Admin\LaporanPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\RiwayatLaporanResponse;
use Kelompok2\SistemTataTertib\Service\AdminService;

class AdminServiceImpl implements AdminService
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function getAllLaporan(): array
    {
        $query = "
        SELECT 
            p.pelaporan_id, 
            m.nama_lengkap, 
            k.pelanggaran, 
            p.verifikasi,
            p.batal
        FROM 
            Rules.Pelaporan p
            JOIN Core.Mahasiswa m ON p.nim = m.nim
            JOIN Rules.KlasifikasiPelanggaran k ON p.klasifikasi_id = k.klasifikasi_pelanggaran_id
        ";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = [];

        while ($row = $statement->fetch()) {
            $riwayatLapor = new RiwayatLaporanResponse();
            $riwayatLapor->id = $row['pelaporan_id'];
            $riwayatLapor->nama_mahasiswa = $row['nama_lengkap'];
            $riwayatLapor->pelanggaran = $row['pelanggaran'];
            $riwayatLapor->verifikasi = $row['verifikasi'];
            $riwayatLapor->batal = $row['batal'];
            $result[] = $riwayatLapor;
        }

        return $result;
    }

    function getDetailLaporan(int $id): DetailLaporanResponse
    {
        $query = " SELECT * FROM vw_DetailLaporan where pelaporan_id = :id";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $detailLaporan = new DetailLaporanResponse(
                nim: $row['nim'],
                namaPelanggar: $row['mahasiswa'],
                kelas: $row['kelas'] . ' ' . $row['prodi'],
                tanggal: $row['tanggal_pelanggaran'],
                namaPelapor: $row['dosen'],
                pelanggaran: $row['pelanggaran'],
                tingkat: $row['tingkat'],
                tingkatKP: $row['tingkatkp'],
                sanksi: $row['sanksi'],
                bukti: $row['bukti'],
                deskripsi: $row['deskripsi'],
                verifikasi: $row['verifikasi'],
                batal: $row['batal']
            );
            return $detailLaporan;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function kirimLaporan(int $id, int $tingkat): void
    {
        $query = "
        INSERT INTO Rules.PelanggaranMahasiswa (pelaporan_id) VALUES (:id)
        ";

        $query2 = "
            UPDATE Rules.Pelaporan 
            SET 
                verifikasi = 1,
                tingkat = :tingkat,
                klasifikasi_id = :klasifikasi
            WHERE pelaporan_id = :id;
        ";

        $query3 = "
        SELECT k.klasifikasi_pelanggaran_id
                    FROM Rules.KlasifikasiPelanggaran k
                    WHERE k.tingkat = :tingkat AND k.pelanggaran = (
                        SELECT k2.pelanggaran
                        FROM Rules.KlasifikasiPelanggaran k2
                        JOIN Rules.Pelaporan p2 ON p2.klasifikasi_id = k2.klasifikasi_pelanggaran_id
                        WHERE p2.pelaporan_id = :id
        )
                    ";


        try {
            Database::beginTransaction();
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();

            $statement3 = $this->connection->prepare($query3);
            $statement3->bindParam('tingkat', $tingkat);
            $statement3->bindParam('id', $id);
            $statement3->execute();

            $klasifikasi = $statement3->fetch()['klasifikasi_pelanggaran_id'];

            $statement2 = $this->connection->prepare($query2);
            $statement2->bindParam('id', $id);
            $statement2->bindParam('tingkat', $tingkat);
            $statement2->bindParam('klasifikasi', $klasifikasi);
            $statement2->execute();
            Database::commitTransaction();
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw new \Exception($e->getMessage());
        }
    }

    function batalkanLaporan(int $id): void
    {
        $query = "
        UPDATE Rules.Pelaporan
        SET batal = 1
        WHERE pelaporan_id = :id
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getAllLaporanPelanggaran(): array
    {
        $query = "
        SELECT PM.pelaporan_id,
       m.nama_lengkap,
       kp.pelanggaran,
       PM.status
FROM Rules.PelanggaranMahasiswa PM
         join Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
         JOIN Core.Mahasiswa m ON p.nim = m.nim
         JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = [];

            while ($row = $statement->fetch()) {
                $riwayatLapor = new LaporanPelanggaranResponse();
                $riwayatLapor->id = $row['pelaporan_id'];
                $riwayatLapor->nama_mahasiswa = $row['nama_lengkap'];
                $riwayatLapor->pelanggaran = $row['pelanggaran'];
                $riwayatLapor->status = $row['status'];
                $result[] = $riwayatLapor;
            }

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getDetailLaporanPelanggaran(int $id): DetailLaporanPelanggaranResponse
    {
        $query = "SELECT * FROM vm_DetailPelanggaranMahasiswa where pelaporan_id = :id";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();
            $row = $statement->fetch();

            $detailLaporanPelanggaran = new DetailLaporanPelanggaranResponse(
                nim: $row['nim'],
                namaPelanggar: $row['nama_lengkap'],
                kelas: $row['kelas'] . ' ' . $row['prodi'],
                tanggal: $row['tanggal_pelanggaran'],
                pelanggaran: $row['pelanggaran'],
                tingkat: $row['tingkat'],
                tingkatKP: $row['tingkatKP'],
                sanksi: $row['sanksi'],
                bukti: $row['bukti'],
                deskripsi: $row['deskripsi'],
                suratPernyataan: $row['surat_bebas_sanksi'],
                status: $row['status']
            );

            return $detailLaporanPelanggaran;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function bebasPelanggaran(int $id): void
    {
        $query = "
        UPDATE Rules.PelanggaranMahasiswa
        SET status = 1
        WHERE pelaporan_id = :id
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getLaporanPertahun(int $tahun): array
    {
        $query = "SELECT * FROM Rules.GetJumlahPelaporanPerTahun(:tahun, NULL, NULL)";
        $query2 = "SELECT * FROM Rules.GetJumlahPelaporanKeseluruhan(NULL, NULL)";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('tahun', $tahun);
            $statement->execute();
            $result = [
              'tahun' => [0,0,0,0,0,0,0,0,0,0,0,0],
                'total' => 0
            ];

            while ($row = $statement->fetch()) {
                $result['tahun'][$row['Bulan']-1] = (int)$row['JumlahPelaporan'];
            }

            $statement2 = $this->connection->prepare($query2);
            $statement2->execute();
            $result['total'] = $statement2->fetch()['JumlahPelaporan'];

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function getAllTahun(): array
    {
        $query1 = "SELECT DISTINCT YEAR(tanggal_pelanggaran) AS Tahun FROM Rules.Pelaporan WHERE verifikasi = 1";

        try {
            $statement = $this->connection->prepare($query1);
            $statement->execute();
            $result = [];

            while ($row = $statement->fetch()) {
                $result[] = $row['Tahun'];
            }

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}