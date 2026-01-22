<?php
session_start();
include "../../Controller/RequestController.php";

$controller = new RequestController();

$applications = $controller->getApplications();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Applications</title>
</head>
<body>
    <h2>My Applied Jobs</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Request ID</th>
            <th>Request Date</th>
            <th>Job ID</th>
            <th>Title</th>
            <th>Company</th>
            <th>Status</th>
        </tr>
        <?php
        if (!empty($applications)) {
            foreach ($applications as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['request_id']) . "</td>
                        <td>" . htmlspecialchars($row['request_date']) . "</td>
                        <td>" . htmlspecialchars($row['jobId']) . "</td>
                        <td>" . htmlspecialchars($row['jobtitle']) . "</td>
                        <td>" . htmlspecialchars($row['companyname']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No applications found</td></tr>";
        }
        ?>
    </table>
    <button onclick="window.location.href='studenthome.php'">Back</button>
    <button onclick="window.location.href='../Logout.php'">Logout</button>
</body>
</html>
