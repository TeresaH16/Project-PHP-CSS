<?php

class Database {
    private const DB_HOST = '172.31.22.43';
    private const DB_NAME = 'retro_store'; //has to match my database
    private const DB_USER = 'Teresita200625088'; // Georgian server
    private const DB_PASS = 'FY879wDH2L'; //Georgian server

    private static ?Database $instance = null;
    private PDO $pdo;

    /**
     * Private constructor.
     */
    private function __construct() {
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
    }

    /**
     * returns the single database instance.
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Returns the raw PDO connection.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * run a prepared statement with optional parameters
     */
    public function run(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}








































