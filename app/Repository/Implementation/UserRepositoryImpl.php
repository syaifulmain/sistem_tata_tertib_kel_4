<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        $statement = $this->connection->prepare("INSERT INTO Admin.Users (username, password_hash, level) VALUES (:username, :password, :level)");
        $statement->bindParam("username", $user->username);
        $statement->bindParam("password", $user->password);
        $statement->bindParam("level", $user->level);
        $statement->execute();
    }

    public function findUserByUsername(string $username): ?User
    {
        $statement = $this->connection->prepare("SELECT username, password_hash, level FROM Admin.Users WHERE username = :username");
        $statement->bindParam("username", $username);
        $statement->execute();
        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->username = $row['username'];
                $user->password = $row['password_hash'];
                $user->level = $row['level'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    function findUserById(int $id): ?User
    {
        $statement = $this->connection->prepare("SELECT username, password_hash, level FROM Admin.Users WHERE id = :id");
        $statement->bindParam("id", $id);
        $statement->execute();
        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->username = $row['username'];
                $user->password = $row['password_hash'];
                $user->level = $row['level'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM Admin.Users");
    }

    function deleteUserByUsername(string $username): void
    {
        $statement = $this->connection->prepare("DELETE FROM Admin.Users WHERE username = :username");
        $statement->bindParam("username", $username);
        $statement->execute();
    }
}