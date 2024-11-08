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
    function save(Session $session): Session
    {
        $statement = $this->connection->prepare("INSERT INTO sessions(session_token, user_id) VALUES (?, ?)");
        $statement->execute([$session->session_token, $session->user_id]);
        return $session;
    }

    function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare("SELECT session_token, user_id from sessions WHERE session_token = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $session = new Session();
                $session->session_token = $row['session_token'];
                $session->user_id = $row['user_id'];
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    function deleteById(string $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE session_token = ?");
        $statement->execute([$id]);
    }
}