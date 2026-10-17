<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    public function __construct()
    {
        // load db config
        $driver = $_ENV['DB_CONNECTION'] ?? 'mysql';
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $database = $_ENV['DB_NAME'] ?? '';
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        switch ($driver) {
            case 'mysql':
                $dsn = "mysql:host={$host};port={$port};dbname={$database};charset={$charset}";
                break;
            case 'pgsql':
                $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
                break;
            default:
                throw new \Exception("Driver-ul '{$driver}' nu este suportat.");
        }

        // Construim DSN-ul în funcție de driver
        try {

            // Creăm conexiunea PDO
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new \Exception("Eroare de conexiune: " . $e->getMessage());
        }
    }

    // Metoda statică prin care se obține conexiunea unică PDO
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public static function connection()
    {
        return self::getInstance()->getPdo();
    }
}