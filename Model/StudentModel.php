<?php
require_once "dbconnect.php";

class StudentModel {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    public function getAllStudents(): array {
        $sql = "SELECT id, name, email FROM users ORDER BY id ASC";
        $result = $this->conn->query($sql);

        $students = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }

public function getStudentById(int $id): ?array {
    if ($id <= 0) return null;  // id 0 hole null ashbe 

    $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE id=?");
    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    return $student ?: null;
}


    public function updateStudent(int $id, string $name, string $email): bool {
        $stmt = $this->conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function deleteStudent(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
