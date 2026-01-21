<?php
session_start();

require_once "../../Controller/ProjectController.php";

//$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['student_id']);
//if (!$isLoggedIn) {
    //header("Location: signin.php");
    //exit;
//}
if (!isset($_SESSION['applied_projects'])) {
    $_SESSION['applied_projects'] = [];
}
$appliedIds = &$_SESSION['applied_projects'];

//db here
$projects = [
    [
        'id' => 1,
        'title' => 'Website for Start-up',
        'company' => 'Brainstation23',
        'description' => 'Need a student to refine design and functionality.',
        'commission' => '$500',
        'email' => 'contact@gmail.com',
        'deadline' => '2025-12-31'
    ],
    [
        'id' => 2,
        'title' => 'React & React Native Portfolio',
        'company' => 'Therap',
        'description' => 'Build a responsive portfolio in React and React Native.',
        'commission' => '$100',
        'email' => 'contact@gmail.com',
        'deadline' => '2025-11-15'
    ]
];

$message = "";
$messageClass = "success";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['project_id'])) {
    $appliedProjectId = intval($_POST['project_id']);

    if (!in_array($appliedProjectId, $appliedIds)) {
        $appliedIds[] = $appliedProjectId;

        foreach ($projects as $project) {
            if ($project['id'] === $appliedProjectId) {
                $message = "Applied successfully for: " . htmlspecialchars($project['title']);
                break;
            }
        }
    } else {
        $message = "You have already applied to this project.";
        $messageClass = "error";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../projects.css">
</head>
<body>

<h2 class="page-title">Available Projects</h2>

<?php if ($message): ?>
    <p class="message <?= $messageClass ?>"><?= $message ?></p>
<?php endif; ?>
<div class="project-list">

    <?php foreach ($projects as $project): ?>
        <div class="project-row">
            <div class="project-left">
                <h3><?= htmlspecialchars($project['title']) ?></h3>
                <p class="company">Company: <?= htmlspecialchars($project['company']) ?></p>
                <p class="description">Description: <?= htmlspecialchars($project['description']) ?></p>
                <p class="commission">Commission: <?= htmlspecialchars($project['commission']) ?></p>
                <p class="email">Email: <?= htmlspecialchars($project['email']) ?></p>
                <p class="deadline">Deadline: <?= htmlspecialchars($project['deadline']) ?></p>
            </div>

            <div class="project-right">
                <form method="POST" class="apply-form">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">

                    <?php
                    $is_applied = in_array($project['id'], $appliedIds);
                    $button_text   = $is_applied ? "Applied" : "Apply";
                    $disabled_attr = $is_applied ? "disabled" : "";
                    $applied_class = $is_applied ? " applied" : "";
                    ?>

                    <button type="submit" class="apply-btn<?= $applied_class ?>" <?= $disabled_attr ?>>
                        <?= $button_text ?>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<script>
    const IS_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;
</script>
<script src="../projects.js"></script>

</body>

</html>
