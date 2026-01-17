<?php
class DatabaseConnection {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "studern";
    private $port = 3306;  

    public function openConnection() {
        $conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db,
            $this->port
        );

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function closeConnection($conn) {
        if ($conn) {
            $conn->close();
        }
    }
}
