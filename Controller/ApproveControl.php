<?php
session_start();
require_once "../Model/ApplicationModel.php";
header("Content-Type: application/json");

if (!isset($_SESSION['id'])) {
    echo json_encode(["success" => false, "message" => "Customer not logged in"]);
    exit;
}

if (!isset($_POST['requestId'])) {
    echo json_encode(["success" => false, "message" => "Missing request ID"]);
    exit;
}

$requestId  = intval($_POST['requestId']);
$customerId = $_SESSION['id'];

$model = new ApplicationsModel();

// Approve this request and reject others for the same job
$success = $model->approveRequest($requestId, $customerId);

if ($success) {
    echo json_encode(["success" => true, "message" => "Request approved"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to approve"]);
}
