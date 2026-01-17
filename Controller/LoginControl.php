<?php
session_start();
require_once "../Model/dbconnect.php";

header("Content-Type: application/json");

$email    = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$remember = $_POST["remember"] ?? "false";

if ($email === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "Email and password are required"
    ]);
    exit;
}

$db = new DatabaseConnection();
$conn = $db->openConnection();

$stmt = $conn->prepare(
    "SELECT id, email, password, role FROM users WHERE email = ?"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
    exit;
}

$_SESSION["id"]    = $user["id"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"]  = $user["role"];

if ($remember === "true") {
    setcookie("remember_email", $email, time() + (86400 * 30), "/");
    setcookie("remember_pass", base64_encode($password), time() + (86400 * 30), "/");
} else {
    setcookie("remember_email", "", time() - 3600, "/");
    setcookie("remember_pass", "", time() - 3600, "/");
}

$redirect = "";
switch ($user["role"]) {
    case "admin":
        $redirect = "../View/Admin_View/adminhome.php";
        break;
    case "customer":
        $redirect = "../View/Company_View/customerhome.php";
        break;
    case "student":
        $redirect = "../View/Student_worker_View/studenthome.php";
        break;
    default:
        $redirect = "../View/Login.php";
}

echo json_encode([
    "success" => true,
    "redirect" => $redirect
]);

$stmt->close();
$db->closeConnection($conn);
