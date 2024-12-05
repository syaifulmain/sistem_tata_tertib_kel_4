<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

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
        $query = "
SELECT m.nama_lengkap as mahasiswa,
       m.nim,
       k.kelas,
       p2.prodi,
       d.nama_lengkap as dosen,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       kp.tingkat,
       s.sanksi,
       p.bukti,
       p.deskripsi,
       p.verifikasi,
       p.batal
        FROM Rules.Pelaporan p
                 JOIN Core.Mahasiswa m ON p.nim = m.nim
                 JOIN Core.Kelas k on k.kelas_id = m.kelas_id
                 Join Core.Prodi p2 on m.prodi_id = p2.prodi_id
                 JOIN Core.Dosen d ON p.nip = d.nip
                 JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
                 JOIN Rules.SanksiPelanggaran s ON kp.sanki_id = s.sanksi_pelanggaran_id
        WHERE p.pelaporan_id = :id;
        ";

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

    function kirimLaporan(int $id): void
    {
        $query = "
        INSERT INTO Rules.PelanggaranMahasiswa (pelaporan_id) VALUES (:id)
        ";

        $query2 = "
        UPDATE Rules.Pelaporan
        SET verifikasi = 1
        WHERE pelaporan_id = :id
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();

            $statement2 = $this->connection->prepare($query2);
            $statement2->bindParam('id', $id);
            $statement2->execute();
        } catch (\Exception $e) {
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
        $query = "
        SELECT m.nama_lengkap,
       m.nim,
       k.kelas,
       p2.prodi,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       kp.tingkat,
       s.sanksi,
       p.bukti,
       p.deskripsi,
       PM.surat_pernyataan,
       PM.status
        FROM Rules.PelanggaranMahasiswa PM
                 join Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
                 JOIN Core.Mahasiswa m ON p.nim = m.nim
                 JOIN Core.Kelas k on k.kelas_id = m.kelas_id
                 Join Core.Prodi p2 on m.prodi_id = p2.prodi_id
                 JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
                 JOIN Rules.SanksiPelanggaran s ON kp.sanki_id = s.sanksi_pelanggaran_id
        WHERE PM.pelaporan_id = :id;
        ";

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
                sanksi: $row['sanksi'],
                bukti: $row['bukti'],
                deskripsi: $row['deskripsi'],
                suratPernyataan: $row['surat_pernyataan'],
                status: $row['status']
            );

            return $detailLaporanPelanggaran;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}