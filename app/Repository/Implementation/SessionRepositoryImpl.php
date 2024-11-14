<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\Session;
use Kelompok2\SistemTataTertib\Repository\SessionRepository;

class SessionRepositoryImpl implements SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    function save(Session $session): void
    {
        $statement = $this->connection->prepare("INSERT INTO Admin.Session(session_token, username) VALUES (:session_token, :username)");
        $statement->bindParam("session_token", $session->session_token);
        $statement->bindParam("username", $session->username);
        $statement->execute();
    }

    function findBySessionToken(string $sessionToken): ?Session
    {
        $statement = $this->connection->prepare("SELECT session_token, username FROM Admin.Session WHERE session_token = :session_token");
        $statement->bindParam("session_token", $sessionToken);
        $statement->execute();

        try {
            if ($row = $statement->fetch()) {
                $session = new Session();
                $session->session_token = $row['session_token'];
                $session->username = $row['username'];
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    function deleteBySessionToken(string $sessionToken): void
    {
        $statement = $this->connection->prepare("DELETE FROM Admin.Session WHERE session_token = :session_token");
        $statement->bindParam("session_token", $sessionToken);
        $statement->execute();
    }

    function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM Admin.Session");
    }

    function deleteSessionByUsername(string $username): void
    {
        $statement = $this->connection->prepare("DELETE FROM Admin.Session WHERE username = :username");
        $statement->bindParam("username", $username);
        $statement->execute();
    }

    function checkSessionIsExitByUsername(string $username): bool
    {
        $statement = $this->connection->prepare("SELECT session_token, username FROM Admin.Session WHERE username = :username");
        $statement->bindParam("username", $username);
        $statement->execute();

        try {
            if ($row = $statement->fetch()) {
                return true;
            } else {
                return false;
            }
        } finally {
            $statement->closeCursor();
        }
    }
}