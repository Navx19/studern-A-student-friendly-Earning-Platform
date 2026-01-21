<?php
require_once __DIR__ . "/../Model/RequestModel.php";

class RequestController {
    public function __construct() {
        $this->model = new RequestModel();
    }

    public function getApplications() {
        $userId = $_SESSION['id'] ?? null;
        if (!$userId) {
            header("Location: ../View/Login.php");
            exit;
        }
        return $this->model->getApplicationsByUser($userId);
    }
}

// Instantiate controller when included
$controller = new RequestController();
