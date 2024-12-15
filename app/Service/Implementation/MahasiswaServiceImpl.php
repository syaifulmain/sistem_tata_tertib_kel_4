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
        $query = "SELECT * FROM vm_DetailPelanggaranMahasiswa where pelaporan_id = :id";

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

    function getLaporanPertahun(int $tahun): array
    {
        $nim = (int)$this->getCurrentUsername();
        $query = "SELECT * FROM Rules.GetJumlahPelaporanPerTahun(:tahun, NULL, :nim)";
        $query2 = "SELECT * FROM Rules.GetJumlahPelaporanKeseluruhan(NULL, :nim)";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('tahun', $tahun);
            $statement->bindParam('nim', $nim);
            $statement->execute();
            $result = [
                'tahun' => [0,0,0,0,0,0,0,0,0,0,0,0],
                'total' => 0
            ];

            while ($row = $statement->fetch()) {
                $result['tahun'][$row['Bulan']-1] = (int)$row['JumlahPelaporan'];
            }

            $statement2 = $this->connection->prepare($query2);
            $statement2->bindParam('nim', $nim);
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