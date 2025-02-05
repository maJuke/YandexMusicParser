<?php

require_once 'DBConnectInterface.php';

class DBConnect implements DBConnectInterface {
    private $conn;

    public function __construct(string $serverAddress,
                                string $username,
                                string $dbName) {
        $this->conn = new mysqli($serverAddress, $username, null, $dbName);

        if ($this->conn->connect_error) {
            die("Нет соединения с БД! " . $this->conn->connect_error);
        }
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }

    public function close(): void {
        $this->conn->close();
    }
}