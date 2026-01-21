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
        $stmt = $this->conn->prepare("SELECT userId, name, email FROM users WHERE role='student' ORDER BY userId ");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getCompanies()
    {
        $stmt = $this->conn->prepare("SELECT userId, name, email FROM users WHERE role='customer' ORDER BY userId ");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProjects()
    {
        $stmt = $this->conn->prepare("SELECT jobId, jobtitle, companyname, jobdescription, commission FROM jobs ORDER BY jobId");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT userId, name, email, role FROM users WHERE userId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function updateUser($id, $name, $email, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE userId=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE userId=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findUser($id)
    {
        return $this->getUserById($id);
    }

    public function saveMessage($userId, $subject, $message)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO admin_messages (userId, subject, message, created_at)
         VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("iss", $userId, $subject, $message);
        return $stmt->execute();
    }

        public function getAllMessages() {
    $sql = "
        SELECT m.message_id, u.name, u.email, m.subject, m.message, m.created_at
        FROM admin_messages m
        JOIN users u ON m.userId = u.userId
        ORDER BY m.created_at DESC
    ";
    $result = $this->conn->query($sql);

    $messages = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
    return $messages;
}

public function findProject($projectId) {
    $stmt = $this->conn->prepare("SELECT * FROM jobs WHERE jobId=?");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

public function updateProject($projectId, $title, $description) {
    $stmt = $this->conn->prepare("UPDATE jobs SET jobtitle=?, jobdescription=? WHERE jobId=?");
    $stmt->bind_param("sss", $title, $description, $projectId);
    return $stmt->execute();
}

public function deleteProject($projectId) {
    $stmt = $this->conn->prepare("DELETE FROM jobs WHERE jobId=?");
    $stmt->bind_param("i", $projectId);
    return $stmt->execute();
}





    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
