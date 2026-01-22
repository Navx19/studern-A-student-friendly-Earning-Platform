<?php
session_start();
require_once __DIR__ . "/../../Model/adminModel.php";

$adminModel = new AdminModel();

$students = $adminModel->getAllStudents();
$companies = $adminModel->getAllCompanies();
$projects = $adminModel->getAllProjects();
$users = $adminModel->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en" class="dark-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>studern Admin Dashboard</title>
    <link rel="stylesheet" href="../Css/adminhome.css">
</head>

<body class="dark-theme">

<header class="top-header">
    <div class="logo">studern Admin</div>
    <nav class="main-nav">
        <a href="../../Controller/admin/manageStudents.php">MANAGE STUDENTS</a>
        <a href="../../Controller/admin/manageCompanies.php">MANAGE CUSTOMERS</a>
        <a href="../../Controller/admin/manageProjects.php">MANAGE PROJECTS</a>
        <a href="adminfeedback.php">FEEDBACK</a>
        <a href="../logout.php" class="btn-logout">LOGOUT</a>
    </nav>
</header>

<main class="admin-main">
    <div class="container">

        <h1 class="dashboard-title">Admin Dashboard</h1>
        <p class="dashboard-subtitle">Overview of platform activity and registrations</p>

        <div class="stats-grid">
            <div class="stat-card glass">
                <h3>Total Students</h3>
                <div class="stat-number"><?= $students ?></div>
            </div>
            <div class="stat-card glass">
                <h3>Total Customers</h3>
                <div class="stat-number"><?= $companies ?></div>
            </div>
            <div class="stat-card glass">
                <h3>Projects Posted</h3>
                <div class="stat-number"><?= $projects ?></div>
            </div>
            <div class="stat-card glass">
                <h3>Total Users</h3>
                <div class="stat-number"><?= $users ?></div>
            </div>
        </div>

        <div class="section-card glass">
            <h2 class="section-title">Recent Student Registrations</h2>
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $studentResult = $adminModel->getStudents();
                        if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                            while ($studentRow = mysqli_fetch_assoc($studentResult)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($studentRow['userId']) . "</td>
                                    <td>" . htmlspecialchars($studentRow['name']) . "</td>
                                    <td>" . htmlspecialchars($studentRow['email']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='no-data'>No students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section-card glass">
            <h2 class="section-title">Recent Company Registrations</h2>
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $companyResult = $adminModel->getCompanies();
                        if ($companyResult && mysqli_num_rows($companyResult) > 0) {
                            while ($companyRow = mysqli_fetch_assoc($companyResult)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($companyRow['userId']) . "</td>
                                    <td>" . htmlspecialchars($companyRow['name']) . "</td>
                                    <td>" . htmlspecialchars($companyRow['email']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='no-data'>No companies found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="section-card glass">
            <h2 class="section-title">Projects Posted</h2>
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Description</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $projectResult = $adminModel->getProjects();
                        if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                            while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($projectRow['jobId']) . "</td>
                                    <td>" . htmlspecialchars($projectRow['jobtitle']) . "</td>
                                    <td>" . htmlspecialchars($projectRow['companyname']) . "</td>
                                    <td class='description-cell'>" . htmlspecialchars($projectRow['jobdescription']) . "</td>
                                    <td>" . htmlspecialchars($projectRow['commission']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='no-data'>No projects found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

</body>
</html>