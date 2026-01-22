<?php
require_once "dbconnect.php";

class ApplicationsModel
{
    private $conn;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    public function getApplicationsByCustomer($customerId)
    {
        $sql = "SELECT
        j.jobtitle,
        j.jobId,
        r.status,
        u.userId,
        u.name,
        u.email,
        r.request_id
    FROM jobs j
    JOIN request r ON j.jobId = r.jobId
    JOIN users u ON r.userId = u.userId
    WHERE j.customerId = ?
    ORDER BY j.jobId, r.request_date DESC
";


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();

        $applications = [];
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }

        $stmt->close();
        return $applications;
    }

    public function approveRequest($requestId, $customerId)
    {
        // job khuji
        $stmt = $this->conn->prepare("SELECT jobId FROM request WHERE request_id=?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$row = $result->fetch_assoc()) {
            return false;
        }
        $jobId = $row['jobId'];
        $stmt->close();

        // jodi eta approve hoi
        $stmt = $this->conn->prepare("UPDATE request SET status='approved' WHERE request_id=?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $stmt->close();

        // baki gula reject
        $stmt = $this->conn->prepare("UPDATE request SET status='rejected' WHERE jobId=? AND request_id=?");
        $stmt->bind_param("ii", $jobId, $requestId);
        $stmt->execute();
        $stmt->close();

        return true;
    }
}
