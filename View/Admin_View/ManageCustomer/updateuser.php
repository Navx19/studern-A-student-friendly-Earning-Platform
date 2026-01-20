<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../View/Login.php");
    exit();
}

require_once __DIR__ . "/../../../Model/adminModel.php";
$adminModel = new AdminModel();

$user = $adminModel->findUser($_GET["user_id"]);
?>
<!doctype html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Update User Information</h1>
    <form action="../../../Controller/admin/manageCompanies.php" method="POST">
        User ID:
        <input type="text" name="userId" value="<?php echo $user['userId']; ?>" readonly><br><br>

        Name:
        <input type="text" name="name" value="<?php echo $user['name']; ?>"><br><br>

        Email:
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

        Role:
        <select name="role">
            <option value="student" <?php if($user['role']=='student') echo 'selected'; ?>>Student</option>
            <option value="customer" <?php if($user['role']=='customer') echo 'selected'; ?>>Customer</option>
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
        </select><br><br>

        <input type="submit" value="Submit" name="submit">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
