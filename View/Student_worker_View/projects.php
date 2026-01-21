<?php
session_start();
require_once "../../Controller/ProjectController.php";

$message = $_GET['msg'] ?? "";
$resultMsg = $controller->handleApply();//apply korar jonno
$projectResult = $controller->getProjects(); // shob project pabar jonno
?>
<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
</head>
<body>
    <h2>Available Projects</h2>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <?php if ($resultMsg): ?>
        <p><?= htmlspecialchars($resultMsg['msg']) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Project ID</th>
            <th>Title</th>
            <th>Company</th>
            <th>Description</th>
            <th>Commission</th>
            <th>Apply</th>
        </tr>
        <?php
        if ($projectResult && mysqli_num_rows($projectResult) > 0) {
            while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                echo "<tr>
                    <td>" . htmlspecialchars($projectRow['jobId']) . "</td>
                    <td>" . htmlspecialchars($projectRow['jobtitle']) . "</td>
                    <td>" . htmlspecialchars($projectRow['companyname']) . "</td>
                    <td>" . htmlspecialchars($projectRow['jobdescription']) . "</td>
                    <td>" . htmlspecialchars($projectRow['commission']) . "</td>
                    <td>
                        <form method='POST'>
                            <input type='hidden' name='jobId' value='" . htmlspecialchars($projectRow['jobId']) . "'>
                            <input type='submit' name='apply' value='Apply'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No projects found</td></tr>";
        }
        ?>
    </table>
    <button onclick="window.location.href='../Student_worker_View/studenthome.php'">Back</button>
</body>
</html>
