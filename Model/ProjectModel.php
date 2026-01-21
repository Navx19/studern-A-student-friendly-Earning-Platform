<?php
require_once "dbconnect.php";

class ProjectModel {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->openConnection();
    }

    // shob project pabe
    public function getProjects() {
        $sql = "SELECT jobId, jobtitle, companyname, jobdescription, commission 
                FROM jobs ORDER BY jobId DESC";
        return $this->conn->query($sql);
    }

    // Apply korlam
    public function applyToProject($userId, $jobId) {
        // ekjon member 2bar apply jate na korte pare
        $stmt = $this->conn->prepare("SELECT request_id FROM request WHERE userId=? AND jobId=?");
        $stmt->bind_param("ii", $userId, $jobId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return ["success" => false, "msg" => "Already applied"];
        }
    //reuest table e dhuktese
        $stmt = $this->conn->prepare(
            "INSERT INTO request (userId, jobId, status, request_date) VALUES (?, ?, 'pending', NOW())"
        );
        $stmt->bind_param("ii", $userId, $jobId);
        if ($stmt->execute()) {
            return ["success" => true, "msg" => "Applied successfully"];
        }
        return ["success" => false, "msg" => "Application failed"];
    }
}
