<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../Login.php");
    exit;
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Admin</title>
</head>
<body>
    <h2>Contact Admin</h2>
    <p>Send Your Feedback to the Admin</p>

    <form action="../Controller/ContactAdminControl.php" method="POST">
        <label for="subject">Subject:</label><br>
        <input type="text" name="subject" id="subject" required><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="6" cols="40" required></textarea><br><br>

        <input type="submit" name="submit" value="Send">
        <input type="reset" value="Reset">
    </form>

    <?php if (isset($_GET['msg'])): ?>
        <p><strong><?php echo htmlspecialchars($_GET['msg']); ?></strong></p>
    <?php endif; ?>

    <br>
    <button type="button" onclick="window.location.href='Logout.php'">Logout </button>
</body>
</html>
