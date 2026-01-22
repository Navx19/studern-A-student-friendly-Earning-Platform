<?php
session_start();
if (!isset($_SESSION['id'])) {
   header("Location: ../Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="dark-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Admin | studern</title>
    <link rel="stylesheet" href="contactadmin.css">
</head>

<body class="dark-theme">

<div class="contact-page">

    <div class="contact-card glass">

        <h2 class="contact-title">Contact Admin</h2>
        <p class="contact-subtitle">Send your feedback, questions or suggestions directly to the admin team</p>

        <form action="../Controller/ContactAdminControl.php" method="POST" class="contact-form">

            <div class="form-group">
                <label class="form-label" for="subject">Subject</label>
                <input type="text" name="subject" id="subject" placeholder="Enter subject..." required autocomplete="off">
            </div>

            <div class="form-group">
                <label class="form-label" for="message">Message</label>
                <textarea name="message" id="message" rows="8" placeholder="Write your message here..." required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-submit">Send Message</button>
                <input type="reset" value="Clear" class="btn-reset">
            </div>

        </form>

        <?php if (isset($_GET['msg'])): ?>
            <div class="feedback-message <?= strpos($_GET['msg'], 'success') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <button type="button" class="btn-back" onclick="window.location.href='Company_View/customerhome.php'">← Back to Home</button>
        </div>

    </div>

</div>

</body>
</html>