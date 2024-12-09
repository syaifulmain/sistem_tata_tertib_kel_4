<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\KlasifikasiPelanggaran;
use Kelompok2\SistemTataTertib\Domain\SanksiPelanggaran;
use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Admin\DetailLaporanResponse;
use Kelompok2\SistemTataTertib\Model\Admin\LaporanPelanggaranResponse;
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

    function getDetailRiwayatLaporan(int $id): DetailRiwayatLaporanResponse
    {
        $query = "
        SELECT  
            m.nama_lengkap,
            m.nim,
            p.tanggal_pelanggaran,
            k.pelanggaran, 
            p.tingkat as tingkat,
            k.tingkat as tingkatkp,
            s.sanksi,
            p.bukti, 
            p.deskripsi
        FROM
            Rules.Pelaporan p
            JOIN Core.Mahasiswa m ON p.nim = m.nim
            JOIN Rules.KlasifikasiPelanggaran k ON p.klasifikasi_id = k.klasifikasi_pelanggaran_id
            JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat
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
            $detailLaporan->tingkatKP = $row['tingkatkp'];
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
        WHERE m.kelas_id = (SELECT kelas_id FROM Core.Kelas WHERE nip = :nip)
        ";

        try {
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
        } catch (\Exception $exception) {
            throw $exception;
        }
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
       p.tingkat as tingkat,
       kp.tingkat as tingkatkp,
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
                 JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat
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

    function getListPelanggaranMahasiswa(): array
    {
        $query = "
        SELECT PM.pelaporan_id,
       m.nama_lengkap,
       kp.pelanggaran,
       PM.status
        FROM Rules.PelanggaranMahasiswa PM
                 join Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
                 JOIN Core.Dosen d ON p.nip = d.nip
                 JOIN Core.Kelas K on d.nip = K.nip
                 JOIN Core.Mahasiswa m ON p.nim = m.nim
                 JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
        WHERE d.nip = :nip AND m.kelas_id = K.kelas_id;
        ";

        try {
            $statement = $this->connection->prepare($query);
            $currentUsername = $this->getCurrentUsername();
            $statement->bindParam('nip', $currentUsername);
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

    function getDetailPelanggaranMahasiswa(int $id): DetailLaporanPelanggaranResponse
    {
        $query = "
        SELECT m.nama_lengkap,
       m.nim,
       k.kelas,
       p2.prodi,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       p.tingkat as tingkat,
       kp.tingkat as tingkatKP,
       s.sanksi,
       p.bukti,
       p.deskripsi,
       PM.surat_bebas_sanksi,
       PM.status
        FROM Rules.PelanggaranMahasiswa PM
                 join Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
                 JOIN Core.Mahasiswa m ON p.nim = m.nim
                 JOIN Core.Kelas k on k.kelas_id = m.kelas_id
                 Join Core.Prodi p2 on m.prodi_id = p2.prodi_id
                 JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
                 JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat
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
}