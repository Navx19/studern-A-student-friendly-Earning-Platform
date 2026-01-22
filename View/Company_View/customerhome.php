<?php
session_start();
require_once "../../Model/ApplicationModel.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../Login.php");
    exit;
}

$customerId = $_SESSION['id'];

$model = new ApplicationsModel();
$applications = $model->getApplicationsByCustomer($customerId);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="Css/customerhome.css">
    <script>
        function approveRequest(requestId) {
            if (!confirm("Approve this request? All others for the same job will be rejected.")) return;

            let result = document.getElementById("result");

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../../Controller/ApproveControl.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                try {
                    let res = JSON.parse(xhr.responseText);
                    result.style.color = res.success ? "green" : "red";
                    result.innerHTML = res.message;
                    if (res.success) {
                        location.reload(); // refresh 
                    }
                } catch (err) {
                    result.style.color = "red";
                    result.innerHTML = "Server error: " + xhr.responseText;
                }
            };

            xhr.send("requestId=" + encodeURIComponent(requestId));
        }
    </script>
</head>

<body>
    <div class="header">
        <h2>studern</h2>
        <h3>Customer Dashboard</h3>
        <div class="header-links">
            <a href="customerhome.php">Home</a>
            <a href="form.php">Post Job</a>
            <a href="cus_profile.php">My Profile</a>
            <a href="../contactadmin.php">Contact Admin</a>
            <a href="../Logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <h2>Welcome</h2>

        <h3>Your Job Applications</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Job Title</th>
                <th>Job ID</th>
                <th>Status</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Action</th>
            </tr>
            <?php
            if (!empty($applications)) {
                foreach ($applications as $app) {
                    echo "<tr>
                            <td>" . htmlspecialchars($app['jobtitle']) . "</td>
                            <td>" . htmlspecialchars($app['jobId']) . "</td>
                            <td>" . htmlspecialchars($app['status']) . "</td>
                            <td>" . htmlspecialchars($app['userId']) . "</td>
                            <td>" . htmlspecialchars($app['name']) . "</td>
                            <td>" . htmlspecialchars($app['email']) . "</td>
                            <td>";
                    if ($app['status'] !== 'approved') {
                        echo "<button onclick='approveRequest(" . htmlspecialchars($app['request_id']) . ")'>Approve</button>";
                    } else {
                        echo "approved";
                    }
                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No applications found for your jobs.</td></tr>";
            }
            ?>
        </table>
        <p id="result" class="result-message"></p>
    </div>
</body>

</html>