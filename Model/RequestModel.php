<?php
require_once "dbconnect.php";

class RequestModel
{
    private $conn;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    public function getApplicationsByUser($userId)
    {
        $sql = "
            SELECT 
                r.request_id,
                r.request_date,
                j.jobId,
                j.jobtitle,
                j.companyname,
                r.status
            FROM request r
            JOIN jobs j ON r.jobId = j.jobId
            WHERE r.userId = ?
            ORDER BY r.request_date DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $applications = [];
        while ($row = $result->fetch_assoc()) {
            $applications[] = $row;
        }

        $stmt->close();
        return $applications;
    }
}
