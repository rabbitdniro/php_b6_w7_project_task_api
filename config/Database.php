<?php

class Database {
    private $serverName = "localhost";
    private $userName = "root";
    private $passWord = "";
    private $dbName = "task_api";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->serverName, $this->userName, $this->passWord, $this->dbName);

        if ($this->conn->connect_error) {
            die(json_encode(["error" => "Database connection failed"]));
        }
    }

    public function getDbConnection() {
        return $this->conn;
    }
}

?>