<?php

namespace quiz\Core;

use PDO;

class Database
{
    private PDO $connection;
    public static ?Database $instance = null;

    public function __construct()
    {
        // return existing instance of connection or create new
        if (self::$instance === null) {
            self::$instance = $this;
        }
        $config = require('src/Config/config.php');

        $this->connection = new PDO(
            $config['dbType'] . ':host=' . $config['host'] . ';dbname=' . $config['dbName'],
            $config['user'],
            $config['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getInstance(): self
    {
        return self::$instance ?? new Database();
    }

    public function connection(): PDO
    {
        return $this->connection;
    }

    public function getAllTests(): array
    {
        $stmt = $this->connection->prepare('SELECT id, name FROM tests');
        $stmt->execute();
        $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tests;
    }



}
