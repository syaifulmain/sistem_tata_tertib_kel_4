<?php

namespace Kelompok2\SistemTataTertib\Config;

use InvalidArgumentException;

class Database
{
    private static ?\PDO $pdo = null;

    /**
     * @throws \InvalidArgumentException if configuration for the specified environment is not found
     * @throws \PDOException if connection failed
     */
    public static function getConnection(string $env = "test"): ?\PDO{
        if(self::$pdo == null){
            require_once __DIR__ . '/../../config/database.php';
            $config = getDatabaseConfig();
            if (!isset($config["database"][$env])) {
                throw new InvalidArgumentException("Database configuration for '$env' not found.");
            }
            try {
                self::$pdo = new \PDO(
                    $config["database"][$env]["url"],
                    $config["database"][$env]["username"],
                    $config["database"][$env]["password"]
                );
            } catch (\PDOException $e) {
                throw new \PDOException("Error connecting to database: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function beginTransaction(){
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction(){
        self::$pdo->commit();
    }

    public static function rollbackTransaction(){
        self::$pdo->rollBack();
    }
}