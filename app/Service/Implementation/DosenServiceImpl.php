<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\KlasifikasiPelanggaran;
use Kelompok2\SistemTataTertib\Domain\SanksiPelanggaran;
use Kelompok2\SistemTataTertib\Model\Dosen\DetailRiwayatLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\KlasifikasiResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\LaporMahasiswaRequest;
use Kelompok2\SistemTataTertib\Model\Dosen\MahasiswaResponse;
use Kelompok2\SistemTataTertib\Model\Dosen\RiwayatLaporanResponse;
use Kelompok2\SistemTataTertib\Service\DosenService;

class DosenServiceImpl implements DosenService
{
    public static string $LOGIN_SESSION_NAME = "SISTEM-TATA-TERTIB-LOGIN-SESSION";
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function laporMahasiwa(LaporMahasiswaRequest $request): void
    {
        $query = "
        INSERT INTO Rules.Pelaporan 
            (
             nim, 
             nip, 
             tanggal_pelanggaran, 
             klasifikasi_id, 
             deskripsi, 
             bukti
             )
        VALUES 
            (
             :nim, 
             :nip, 
             :tanggal_pelanggaran, 
             :klasifikasi_id, 
             :deskripsi, 
             :bukti
             )
        ";

        try {
            Database::beginTransaction();
            $statement = $this->connection->prepare($query);
            $statement->bindParam('nim', $request->nim);
            $statement->bindParam('nip', $request->nip);
            $statement->bindParam('tanggal_pelanggaran', $request->tanggal);
            $statement->bindParam('klasifikasi_id', $request->klasifikasi_id);
            $statement->bindParam('deskripsi', $request->deskripsi);
            $statement->bindParam('bukti', $request->bukti);
            $statement->execute();
            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    function getAllRiwayatLaporMahasiswaCurrentDosen(): array
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
        WHERE 
            p.nip =  :nip
        ";

        $statement = $this->connection->prepare($query);
        $currentUsername = $this->getCurrentUsername();
        $statement->bindParam('nip', $currentUsername);
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

    function getALlKlasifikasi(): array
    {
        $query = " SELECT klasifikasi_pelanggaran_id, tingkat, pelanggaran FROM Rules.KlasifikasiPelanggaran";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = [];
        while ($row = $statement->fetch()) {
            $klasifikasiPelanggaran = new KlasifikasiResponse();
            $klasifikasiPelanggaran->id = $row['klasifikasi_pelanggaran_id'];
            $klasifikasiPelanggaran->tingkat = $row['tingkat'];
            $klasifikasiPelanggaran->pelanggaran = $row['pelanggaran'];

            $result[] = $klasifikasiPelanggaran;
        }
        return $result;
    }

    function getAllMahasiswa(): array
    {
        $query = "SELECT  nim, nama_lengkap FROM Core.Mahasiswa";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = [];

        while ($row = $statement->fetch()) {
            $mahasiswa = new MahasiswaResponse();
            $mahasiswa->nim = $row['nim'];
            $mahasiswa->nama = $row['nama_lengkap'];
            $result[] = $mahasiswa;
        }

        return $result;
    }

    function getCurrentUsername(): string
    {
        $sessionToken = $_COOKIE[self::$LOGIN_SESSION_NAME] ?? '';

        $query = "SELECT username FROM Admin.Session WHERE session_token = :session_token";

        $statement = $this->connection->prepare($query);
        $statement->bindParam('session_token', $sessionToken);
        $statement->execute();
        $row = $statement->fetch();
        try {
            return $row['username'];
        } catch (\Exception $exception) {
            throw $exception;
        }
//        return '12345678911234567891';
    }

    function getDetailLaporan(int $id): DetailRiwayatLaporanResponse
    {
        $query = "
        SELECT  
            m.nama_lengkap,
            m.nim,
            p.tanggal_pelanggaran,
            k.pelanggaran, 
            k.tingkat,
            s.sanksi,
            p.bukti, 
            p.deskripsi
        FROM
            Rules.Pelaporan p
            JOIN Core.Mahasiswa m ON p.nim = m.nim
            JOIN Rules.KlasifikasiPelanggaran k ON p.klasifikasi_id = k.klasifikasi_pelanggaran_id
            JOIN Rules.SanksiPelanggaran s ON k.sanki_id = s.sanksi_pelanggaran_id
        WHERE
            p.pelaporan_id = :id
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('id', $id);
            $statement->execute();
            $row = $statement->fetch();

            $detailLaporan = new DetailRiwayatLaporanResponse();
            $detailLaporan->nim = $row['nim'];
            $detailLaporan->nama = $row['nama_lengkap'];
            $detailLaporan->tanggal = $row['tanggal_pelanggaran'];
            $detailLaporan->pelanggaran = $row['pelanggaran'];
            $detailLaporan->tingkat = $row['tingkat'];
            $detailLaporan->sanksi = $row['sanksi'];
            $detailLaporan->bukti = $row['bukti'];
            $detailLaporan->deskripsi = $row['deskripsi'];
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $detailLaporan;
    }

    function getAllLaporan(): array
    {
        $query = "
        
        ";

        return [];
    }
}