<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Login.php");
    exit();
}

require_once __DIR__ . "/../../Model/adminModel.php";
$adminModel = new AdminModel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = intval($_POST["id"]);
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $flag = $adminModel->updateUser($id, $name, $email, $role);
    if ($flag) {
        header("Location: ../../View/Admin_View/ManageCustomer/getuser.php?msg=Update Successful");
    } else {
        header("Location: ../../View/Admin_View/ManageCustomer/getuser.php?msg=Update Failed");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    if ($id > 0) {
        $adminModel->deleteUser($id);
        header("Location: ../../View/Admin_View/ManageCustomer/getuser.php?msg=Deletion Successful");
        exit();
    }
}
$users = $adminModel->getCompanies();
include "../../View/Admin_View/ManageCustomer/getuser.php";
