<?php
require_once "dbconnect.php";

class AdminModel {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    //students count
    public function getAllStudents() {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row['total'];
}

public function getAllCompanies() {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row['total'];
}

public function getAllProjects() {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM jobs");
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row['total'];
}

public function getAllUsers() {
    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role IN ('student', 'customer')");
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row['total'];
}

public function getStudents() {
    $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE role='student' ORDER BY id ");
    $stmt->execute();
    return $stmt->get_result();
}

public function getCompanies() {
    $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE role='customer' ORDER BY id ");
    $stmt->execute();
    return $stmt->get_result();
}

public function getProjects() {
    $stmt = $this->conn->prepare("SELECT id, jobtitle, companyname, jobdescription, commission FROM jobs ORDER BY id");
    $stmt->execute();
    return $stmt->get_result();
}


    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>