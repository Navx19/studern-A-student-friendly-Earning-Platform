<?php
require_once __DIR__ . "/../Model/ProjectModel.php";

class ProjectController {
    private $model;

    public function __construct() {
        $this->model = new ProjectModel();
    }
   //project gulo pabe
    public function getProjects() {
        return $this->model->getProjects();
    }
    //apply korar jonno
    public function handleApply() {
        $userId = $_SESSION['id'] ?? null;
        if (!$userId) {
            header("Location: ../View/Login.php");
            exit;
        }
        //button click
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply'])) {
            $jobId = intval($_POST['jobId']);
            return $this->model->applyToProject($userId, $jobId);
        }
        return null;
    }
}
$controller = new ProjectController();
