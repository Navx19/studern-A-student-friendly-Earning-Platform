<?php
require_once "dbconnect.php";

class JobModel {
    private $conn;

    public function __construct() {
    $db = new DatabaseConnection();
    $this->conn = $db->openConnection();
}

public function insertJob($jobtitle, $companyname, $jobdescription, $commission, $contactemail, $deadline, $filename) {

    if (!isset($_SESSION["id"])) {
        return ["success" => false, "message" => "User not logged in"];
    }

    $customerId = $_SESSION["id"];

    $stmt = $this->conn->prepare(
        "INSERT INTO jobs 
        (jobtitle, companyname, jobdescription, commission, contactemail, applicationdeadline, jobfile, customerId)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssdsssi",
      
        $jobtitle,
        $companyname,
        $jobdescription,
        $commission,
        $contactemail,
        $deadline,
        $filename,
        $customerId
    );

    if ($stmt->execute()) {
        return ["success" => true, "message" => "Job posted successfully"];
    } else {
        return ["success" => false, "message" => "Database insert failed: " . $stmt->error];
    }
}
}