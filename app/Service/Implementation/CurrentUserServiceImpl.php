<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Model\User\ProfilUserResponse;
use Kelompok2\SistemTataTertib\Service\CurrentUserService;

class CurrentUserServiceImpl implements CurrentUserService
{
    public static string $LOGIN_SESSION_NAME = "SISTEM-TATA-TERTIB-LOGIN-SESSION";
    public static string $CURRENT_USER = "SISTEM-TATA-TERTIB-USERNAME";

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function getUsernameAndName(string $username): void
    {

        $query = "
        SELECT level FROM Admin.Users WHERE username = :username
        ";

        try {

            $statement = $this->connection->prepare($query);
            $statement->bindParam('username', $username);

            $statement->execute();
            $row = $statement->fetch();

            $username = $username;
            $level = $row['level'];

            if ($level == 'mahasiswa') {
                $query = "
            SELECT nama_lengkap FROM Core.Mahasiswa WHERE nim = :username
            ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam('username', $username);
                $statement->execute();
                $row = $statement->fetch();

                $username = $username . '/' . $row['nama_lengkap'];

            } else if ($level == 'dosen') {
                $query = "
            SELECT nama_lengkap FROM Core.Dosen WHERE nip = :username
            ";
                $statement = $this->connection->prepare($query);
                $statement->bindParam('username', $username);
                $statement->execute();
                $row = $statement->fetch();

                $username = $username . '/' . $row['nama_lengkap'];
            } else {
                $username = $username . '/admin';
            }

            setcookie(self::$CURRENT_USER, $username, time() + (60 * 60 * 24 * 30), "/");
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    function getInfoUser(string $username): ProfilUserResponse
    {
        $query = "
        SELECT level FROM Admin.Users WHERE username = :username
        ";

        try {
            $statement = $this->connection->prepare($query);
            $statement->bindParam('username', $username);
            $statement->execute();
            $row = $statement->fetch();

            $level = $row['level'];

            if ($level == 'mahasiswa') {
                $query = "
                SELECT M.nim,
                   M.nama_lengkap,
                   M.no_telepon,
                   M.email,
                   K.kelas,
                   P.prodi
                    FROM Core.Mahasiswa M
                             JOIN Core.Kelas K on K.kelas_id = M.kelas_id
                             JOIN Core.Prodi P on M.prodi_id = P.prodi_id
                    WHERE M.nim = :username;
               ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam('username', $username);
                $statement->execute();
                $row = $statement->fetch();

                return new ProfilUserResponse(
                    $row['nama_lengkap'],
                    $row['nim'],
                    $row['email'],
                    $row['no_telepon'],
                    $row['prodi'] . '/' . $row['kelas']
                );
            } else if ($level == 'dosen') {
                $query = "
                SELECT D.nip,
                   D.nama_lengkap,
                   D.no_telepon,
                   D.email,
                   K.kelas
                    FROM Core.Dosen D
                             JOIN Core.Kelas K on D.nip = K.nip
                    WHERE D.nip = :username;
                ";

                $statement = $this->connection->prepare($query);
                $statement->bindParam('username', $username);
                $statement->execute();
                $row = $statement->fetch();

                return new ProfilUserResponse(
                    $row['nama_lengkap'],
                    $row['nip'],
                    $row['email'],
                    $row['no_telepon'],
                    $row['kelas']
                );
            } else {
                throw new \Exception("User not found");
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}