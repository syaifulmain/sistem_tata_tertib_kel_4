<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Model\Mahasiswa\DetailPelanggaranResponse;
use Kelompok2\SistemTataTertib\Model\Mahasiswa\KirimSuratPernyataanRequest;
use Kelompok2\SistemTataTertib\Model\Mahasiswa\PelanggaranMahasiswaResponse;
use Kelompok2\SistemTataTertib\Service\MahasiswaService;

class MahasiswaServiceImpl implements MahasiswaService
{
    public static string $LOGIN_SESSION_NAME = "SISTEM-TATA-TERTIB-LOGIN-SESSION";

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function getAllPelanggaran(): array
    {
        $query = "
        SELECT PM.pelaporan_id,
       KP.pelanggaran,
       KP.tingkat,
       P.tanggal_pelanggaran,
       PM.status,
       IIF(PM.surat_bebas_sanksi IS NULL, 0, 1) as surat_bebas_sanksi
        FROM Rules.PelanggaranMahasiswa PM
                 JOIN Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
                 JOIN Rules.KlasifikasiPelanggaran KP on KP.klasifikasi_pelanggaran_id = P.klasifikasi_id
        WHERE P.nim = :nim
        ";

        try {
            $statement = $this->connection->prepare($query);
            $currentUsername = $this->getCurrentUsername();
            $statement->bindParam('nim', $currentUsername);
            $statement->execute();
            $result = [];

            while ($row = $statement->fetch()) {
                $pelanggaran = new PelanggaranMahasiswaResponse(
                    id: $row['pelaporan_id'],
                    pelanggaran: $row['pelanggaran'],
                    tingkat: $row['tingkat'],
                    tanggal: $row['tanggal_pelanggaran'],
                    status: $row['status'],
                    kirimDokumenStatus: $row['surat_bebas_sanksi']
                );
                $result[] = $pelanggaran;
            }

            return $result;
        } catch (\Exception $exception) {
            throw $exception;
        }
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
    }

    function simpanSuratPernyataan(KirimSuratPernyataanRequest $request): void
    {
        $query = "
        UPDATE Rules.PelanggaranMahasiswa SET surat_bebas_sanksi = :surat_bebas_sanksi WHERE pelaporan_id = :id;
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('surat_bebas_sanksi', $request->suratPernyataan);
            $statement->bindParam('id', $request->id);
            $statement->execute();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    function getDetailPelanggaran(int $id): DetailPelanggaranResponse
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
            $detailPelanggaran = new DetailPelanggaranResponse(
                nama: $row['nama_lengkap'],
                nim: $row['nim'],
                kelas: $row['kelas'] . ' ' . $row['prodi'],
                tanggal: $row['tanggal_pelanggaran'],
                pelanggaran: $row['pelanggaran'],
                tingkat: $row['tingkat'],
                tingkatKP: $row['tingkatKP'],
                sanksi: $row['sanksi'],
                bukti: $row['bukti'],
                deskripsi: $row['deskripsi'],
                suratBebasSanksi: $row['surat_bebas_sanksi'],
                status: $row['status']
            );
            return $detailPelanggaran;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}