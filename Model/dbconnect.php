<?php
class DatabaseConnection {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "studern";

    public function openConnection() {
        $conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($conn->connect_error) {
            die("Database connection failed");
        }

        return $conn;
    }

    public function closeConnection($conn) {
        $conn->close();
    }
}
