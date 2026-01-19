<?php
require_once "dbconnect.php";

class AdminModel
{
    private $conn;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    public function getAllStudents()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row['total'];
    }

    public function getAllCompanies()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row['total'];
    }

    public function getAllProjects()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM jobs");
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row['total'];
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role IN ('student', 'customer')");
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row['total'];
    }

    public function getStudents()
    {
        $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE role='student' ORDER BY id ");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getCompanies()
    {
        $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE role='customer' ORDER BY id ");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProjects()
    {
        $stmt = $this->conn->prepare("SELECT id, jobtitle, companyname, jobdescription, commission FROM jobs ORDER BY id");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function updateUser($id, $name, $email, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findUser($id)
    {
        return $this->getUserById($id);
    }



    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
