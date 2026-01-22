<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../View/Login.php");
    exit();
}

include '../../../Controller/admin/studentmanagecontroller.php';

$controller = new StudentManageController();

$customers        = $controller->getAllCustomers();
$editing_id       = $controller->getEditingId();
$editing_customer = $editing_id > 0 ? $controller->getCustomerForEdit($editing_id) : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Information Manage</title>
    <link rel="stylesheet" href="studentmanage.css">
</head>
<body>

<h1>Student Information Management</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    <?php foreach ($customers as $cust): ?>
    <tr>
        <td><?= htmlspecialchars($cust['id']) ?></td>
        <td><?= htmlspecialchars($cust['name']) ?></td>
        <td><?= htmlspecialchars($cust['email']) ?></td>
        <td><a href="?action=update&id=<?= $cust['id'] ?>">Update</a></td>
        <td>
            <a href="?action=delete&id=<?= $cust['id'] ?>"
               onclick="return confirm('Are you sure you want to delete this student?');">
                Delete
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>

<?php if ($controller->isEditing() && $editing_customer): ?>
    <h2>Update Student (ID: <?= $editing_customer['id'] ?>)</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $editing_customer['id'] ?>">
        Name:<br>
        <input type="text" name="name" value="<?= htmlspecialchars($editing_customer['name']) ?>" required><br><br>
        Email:<br>
        <input type="email" name="email" value="<?= htmlspecialchars($editing_customer['email']) ?>" required><br><br>
        <input type="submit" name="update" value="Save Changes">
    </form>
    <br>
    <a href="<?= $_SERVER['PHP_SELF'] ?>">← Back to list</a>
<?php endif; ?>

</body>
</html>
