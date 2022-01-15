<?php

namespace App;

use PDOException;
use PDO;

class DatabaseConnection
{
    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "root";
    private $dbName = "hazel";
    private $port = '8889';

    protected function connect()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";port=$this->port";
        try {
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
