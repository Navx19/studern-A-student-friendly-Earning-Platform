<?php
require_once "../Model/JobModel.php";

header("Content-Type: application/json");

// Collect POST data
$jobtitle     = trim($_POST["jobtitle"] ?? "");
$companyname  = trim($_POST["companyname"] ?? "");
$jobdescription = trim($_POST["jobdescription"] ?? "");
$commission   = trim($_POST["commission"] ?? "");
$contactemail = trim($_POST["contactemail"] ?? "");
$deadline     = trim($_POST["applicationdeadline"] ?? "");

// Validation
if ($jobtitle === "" || $companyname === "" || $jobdescription === "" || $commission === "" || $contactemail === "" || $deadline === "") {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}
if (!filter_var($contactemail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format"]);
    exit;
}
if (!is_numeric($commission)) {
    echo json_encode(["success" => false, "message" => "Commission must be a number"]);
    exit;
}

// File upload (optional)
$filename = null;
if (isset($_FILES['jobfile']) && $_FILES['jobfile']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['jobfile']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "File upload error"]);
        exit;
    }

    $file = $_FILES['jobfile'];
    $allowed = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxSize = 2 * 1024 * 1024;

    if (!in_array($file['type'], $allowed)) {
        echo json_encode(["success" => false, "message" => "Only JPG, PNG, PDF allowed"]);
        exit;
    }
    if ($file['size'] > $maxSize) {
        echo json_encode(["success" => false, "message" => "File must be less than 2MB"]);
        exit;
    }

    $uploadDir = "../Resources/JobFiles/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $filename = time() . "_" . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        echo json_encode(["success" => false, "message" => "File upload failed"]);
        exit;
    }
}

// Call Model
$model = new JobModel();
$response = $model->insertJob($jobtitle, $companyname, $jobdescription, $commission, $contactemail, $deadline, $filename);

echo json_encode($response);
