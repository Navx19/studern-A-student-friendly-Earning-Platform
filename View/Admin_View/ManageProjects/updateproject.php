<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../View/Login.php");
    exit();
}

require_once __DIR__ . "/../../../Model/adminModel.php";
$adminModel = new AdminModel();

$project = $adminModel->findProject($_GET["project_id"]);
?>
<!doctype html>
<html>
<head>
    <title>Update Project</title>
</head>
<body>
    <h1>Update Project Information</h1>
    <form action="../../../Controller/admin/manageProjects.php" method="POST">
        Project ID:
        <input type="text" name="projectId" value="<?php echo $project['jobId']; ?>" readonly><br><br>

        Title:
        <input type="text" name="title" value="<?php echo $project['jobtitle']; ?>"><br><br>

        Description:
        <textarea name="description" rows="4" cols="20"><?php echo $project['jobdescription']; ?></textarea><br><br>

        <input type="submit" value="Submit" name="submit">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
