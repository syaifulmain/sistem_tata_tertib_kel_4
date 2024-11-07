<?php

namespace Kelompok2\SistemTataTertib\Repository\Implementation;

use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Model\User\UserUpdateRequest;
use Kelompok2\SistemTataTertib\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): User
    {
        $statement = $this->pdo->prepare("INSERT INTO Admin.Users (username, password_hash, level) VALUES (:username, :password, :level)");
        $statement->bindParam("username", $user->username);
        $statement->bindParam("password", $user->password);
        $statement->bindParam("level", $user->level);
        $statement->execute();
        return $user;
    }

    public function findUserByUsername(string $username): ?User
    {
        $statement = $this->pdo->prepare("SELECT username, password_hash, level FROM Admin.Users WHERE username = :username");
        $statement->bindParam("username", $username);
        $statement->execute();
        try {
            $row = $statement->fetch();
            if ($row === false) {
                return null;
            }
            $user = new User();
            $user->username = $row["username"];
            $user->password = $row["password_hash"];
            $user->level = $row["level"];
            return $user;
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM Admin.Users");
    }

    function findUserById(int $id): ?User
    {
        $statement = $this->pdo->prepare("SELECT username, password_hash, level FROM Admin.Users WHERE id = :id");
        $statement->bindParam("id", $id);
        $statement->execute();
        try {
            $row = $statement->fetch();
            if ($row === false) {
                return null;
            }
            $user = new User();
            $user->username = $row["username"];
            $user->password = $row["password_hash"];
            $user->level = $row["level"];
            return $user;
        } finally {
            $statement->closeCursor();
        }
    }
}