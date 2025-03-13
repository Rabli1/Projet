<?php

class Database
{
    private static $instance;
    private $conn;

    private function __construct(array $dbConfig, array $dbParams)
    {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $dbConfig["hostname"] . ";dbname=" . $dbConfig["database"],
                $dbConfig["username"],
                $dbConfig["password"],
                $dbParams
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public static function getInstance(array $dbConfig, array $dbParams): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database($dbConfig, $dbParams);
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->conn;
    }
}

// Configuration de la base de données
$dbConfig = [
    "hostname" => "70.29.200.42",
    "username" => "Justin",
    "password" => "1234",
    "database" => "knapsackdb"
];

// Paramètres PDO
$dbParams = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
