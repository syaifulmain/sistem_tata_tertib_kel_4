<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

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
}