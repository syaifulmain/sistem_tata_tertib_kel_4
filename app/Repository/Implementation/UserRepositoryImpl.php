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
        $statement = $this->pdo->prepare("INSERT INTO Admin.Users (username, password_hash, role) VALUES (:username, :password, :role)");
        $statement->bindParam("username", $user->username);
        $statement->bindParam("password", $user->password);
        $statement->bindParam("role", $user->role);
        $statement->execute();
        return $user;
    }

    public function update(UserUpdateRequest $request): bool
    {
        $statement = $this->pdo->prepare("UPDATE Admin.Users SET password_hash = :password, updated_at = :update_at WHERE username = :username");
        $statement->bindParam("username", $request->username);
        $statement->bindParam("password", $request->newPassword);
        $statement->bindParam("update_at", $request->updated_at);
        return $statement->execute();
    }

    public function findUserByUsername(string $username): ?User
    {
        $statement = $this->pdo->prepare("SELECT username, password_hash, role FROM Admin.Users WHERE username = :username");
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
            $user->role = $row["role"];
            return $user;
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM Admin.Users");
    }
}