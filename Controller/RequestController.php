<?php
require_once __DIR__ . "/../Model/RequestModel.php";

class RequestController {
    private $model;

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

$controller = new RequestController();
