<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Login.php");
    exit();
}

require_once __DIR__ . "/../../Model/adminModel.php";
$adminModel = new AdminModel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $projectId = intval($_POST["projectId"]);
    $title     = $_POST["title"];
    $desc      = $_POST["description"];

    $flag = $adminModel->updateProject($projectId, $title, $desc);
    if ($flag) {
        header("Location: ../../View/Admin_View/ManageProjects/getproject.php?msg=Update Successful");
    } else {
        header("Location: ../../View/Admin_View/ManageProjects/getproject.php?msg=Update Failed");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $projectId = intval($_POST['projectId']);
    if ($projectId > 0) {
        $adminModel->deleteProject($projectId);
        header("Location: ../../View/Admin_View/ManageProjects/getproject.php?msg=Deletion Successful");
        exit();
    }
}

$projects = $adminModel->getProjects();
include "../../View/Admin_View/ManageProjects/getproject.php";
