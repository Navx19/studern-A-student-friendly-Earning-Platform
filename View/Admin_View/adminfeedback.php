<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/Login.php");
    exit();
}

require_once __DIR__ . "/../../Model/adminModel.php";
$adminModel = new AdminModel(); 

//data retrive
$messages = $adminModel->getAllMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Feedback</title>
    <link rel="stylesheet" href="feedback.css">
</head>
<body>
    <h2>Feedback</h2>
    <table border ="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Message ID</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Sent At</th>
        </tr>
        <?php
        if (!empty($messages)) {
            foreach ($messages as $msg) {
                echo "<tr>
                        <td>" . htmlspecialchars($msg['message_id']) . "</td>
                        <td>" . htmlspecialchars($msg['name']) . "</td>
                        <td>" . htmlspecialchars($msg['email']) . "</td>
                        <td>" . htmlspecialchars($msg['subject']) . "</td>
                        <td>" . nl2br(htmlspecialchars($msg['message'])) . "</td>
                        <td>" . htmlspecialchars($msg['created_at']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No feedback found.</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="adminhome.php"><button type="button">Back</button></a>
    <a href="../Logout.php"><button type="button">Logout</button></a>
</body>
</html>
