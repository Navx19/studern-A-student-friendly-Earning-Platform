<?php
require_once __DIR__ . "/../../../Model/adminModel.php";

$adminModel = new AdminModel();
$projects = $adminModel->getProjects();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Projects</title>
</head>
<body>
    <h1>Project Information</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($projects && mysqli_num_rows($projects) > 0) {
            while ($row = mysqli_fetch_assoc($projects)) {
                echo "<tr>
                        <td>{$row['jobId']}</td>
                        <td>{$row['jobtitle']}</td>
                        <td>{$row['jobdescription']}</td>
                        <td><a href='/studern/View/Admin_View/ManageProjects/updateproject.php?project_id={$row['jobId']}'>Update</a></td>
                        <td>
                            <form method='POST' action='/studern/Controller/admin/manageProjects.php'>
                                <input type='hidden' name='projectId' value='{$row['jobId']}'>
                                <input type='submit' name='delete' value='Delete'>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No projects found.</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="/studern/View/Admin_View/adminhome.php"><button type="button">Back</button></a>
    <a href="../../Logout.php"><button type="button">Logout</button></a>
</body>
</html>
