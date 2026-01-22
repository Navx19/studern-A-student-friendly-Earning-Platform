<?php
session_start();
require_once __DIR__ . "/../../Model/adminModel.php";
$adminModel = new AdminModel();

//card e count
$students = $adminModel->getAllStudents();
$companies = $adminModel->getAllCompanies();
$projects = $adminModel->getAllProjects();
$users = $adminModel->getAllUsers();

?>
<!DOCTYPE html>
<html>

<head>
    <title>studern Admin Dashboard</title>
    <link rel="stylesheet" href="Css/adminhome.css">
</head>

<body>

    <div class="header">
        <h2>studern </h2>
        <h3> Admin Dashboard</h3>
        <div class="header-links">
            <a href="../../Controller/admin/studentmanagecontroller.php">Manage Students</a>
            <a href="../../Controller/admin/manageCompanies.php">Manage Customers</a>
            <a href="../../Controller/admin/manageProjects.php">Manage Projects</a>
            <a href="adminfeedback.php">FeedBack</a>
            <a href="../logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Students</h4>
                <div class="number"><?php echo $students; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Customers</h4>
                <div class="number"><?php echo $companies; ?></div>
            </div>
            <div class="stat-card">
                <h4>Projects Posted</h4>
                <div class="number"><?php echo $projects; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Users</h4>
                <div class="number"><?php echo $users; ?></div>
            </div>

        </div>

        <div class="section">
            <h3>Student Registrations</h3>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                <?php
                $studentResult = $adminModel->getStudents();
                if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                    while ($studentRow = mysqli_fetch_assoc($studentResult)) {
                        echo "<tr>
                            <td>{$studentRow['userId']}</td>
                            <td>{$studentRow['name']}</td>
                            <td>{$studentRow['email']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No students found</td></tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h3>Company Registrations</h3>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                <?php
                $companyResult = $adminModel->getCompanies();
                if ($companyResult && mysqli_num_rows($companyResult) > 0) {
                    while ($companyRow = mysqli_fetch_assoc($companyResult)) {
                        echo "<tr>
                            <td>{$companyRow['userId']}</td>
                            <td>{$companyRow['name']}</td>
                            <td>{$companyRow['email']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No companies found</td></tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h3>Projects Posted</h3>
            <table border="1">
                <tr>
                    <th>Project ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Description</th>
                    <th>Commission</th>
                </tr>
                <?php
                $projectResult = $adminModel->getProjects();

                if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                    while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                        echo "<tr>
            <td>{$projectRow['jobId']}</td>
            <td>{$projectRow['jobtitle']}</td>
            <td>{$projectRow['companyname']}</td>
            <td>{$projectRow['jobdescription']}</td>
            <td>{$projectRow['commission']}</td>
        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No projects found</td></tr>";
                }

                ?>
            </table>
        </div>

    </div>

</body>

</html>