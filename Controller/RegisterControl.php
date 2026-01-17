<?php
require_once "../Model/UserModel.php";

header("Content-Type: application/json");

$name     = trim($_POST["name"] ?? "");
$email    = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$confirm  = trim($_POST["confirm_password"] ?? "");
$role     = trim($_POST["role"] ?? "");

if ($name === "" || $email === "" || $password === "" || $confirm === "" || $role === "") {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format"]);
    exit;
}

if (strlen($password) < 4) {
    echo json_encode(["success" => false, "message" => "Password must be at least 4 characters long"]);
    exit;
}

$userModel = new UserModel();

if ($userModel->emailExists($email)) {
    echo json_encode(["success" => false, "message" => "Email already exists"]);
    exit;
}

if ($userModel->registerUser($name, $email, $password, $role)) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed"]);
}
