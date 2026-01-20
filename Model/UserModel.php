<?php
require_once "dbconnect.php";

class UserModel {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT userId FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $exists = $res->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function registerUser($name, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function __destruct() {
        $db = new DatabaseConnection();
        $db->closeConnection($this->conn);
    }
}
