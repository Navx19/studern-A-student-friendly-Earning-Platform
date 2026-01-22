<?php
session_start();

$studentName = $_SESSION['id'] ?? 'Student';
?>
<!DOCTYPE html>
<html class="dashboard">
<head>
    <title>Student</title>
    <meta name="author" content="Mehrab Ibne Khaled">
    <link rel="stylesheet" href="../studentindex.css">
</head>
<body>
    <img class="gradient_image" src="../../Resources/gradient.png">
    <spline-viewer class="robot" url="https://prod.spline.design/VWDannDaaPiUZtfs/scene.splinecode"></spline-viewer>

    <div class="layerblur"></div>

    <div class="container">
        <header>
            <nav>
                <a href="studenthome.php">HOME</a>
                <a href="projects.php">COMPANIES</a>
                <a href="Requested.php">APPLIED PROJECTS</a>
                <a href="../contactadmin.php">CONTACT ADMIN</a>
                <a href="../Logout.php" class="logout">LOGOUT</a>
            </nav>

            <a href="../../Views/Dashboard/profile.php" class="user-greeting">
                <div class="avatar">
                    <?php echo strtoupper(substr($studentName, 0, 1)); ?>
                </div>
                Hello, <?php echo htmlspecialchars($studentName); ?>
            </a>
        </header>

        <main>
            <div class="contents">
                <div class="tag-box">
                    <div class="tag">WELCOME BACK</div>
                </div>
                <h1>studern</h1>
                <p class="description">Build your career and <br>help the tech giants!</p>
                    <a href="studentprofile.php" class="btn_profile">
                        My Profile
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.12.32/build/spline-viewer.js"></script>
</body>
</html>
