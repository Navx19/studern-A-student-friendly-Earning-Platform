<?php
require_once __DIR__ .  "/../../Model/StudentModel.php";

class StudentManageController {
    private $model;

    public function __construct() {
        $this->model = new StudentModel();
    }

    public function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $this->model->deleteStudent((int)$_GET['id']);
        }

        if (isset($_POST['update'])) {
            $this->model->updateStudent(
                (int)$_POST['id'],
                trim($_POST['name'] ?? ''),
                trim($_POST['email'] ?? '')
            );
            
        }
    }

    public function getAllCustomers(): array {
        return $this->model->getAllStudents();
    }

    public function getCustomerForEdit(int $id): ?array {
    if ($id <= 0) return null;
    return $this->model->getStudentById($id);
}


    public function isEditing(): bool {
        return isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['id']);
    }



    public function getEditingId(): int {
        return $this->isEditing() ? (int)$_GET['id'] : 0;
    }
}

$controller = new StudentManageController();
$controller->handleRequest();
