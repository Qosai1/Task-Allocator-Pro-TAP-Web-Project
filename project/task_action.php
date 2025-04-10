<?php
require 'dbconfig.in.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Variables for confirmation messages
$message = "";
$message_class = "";

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['assignment_id'])) {
    $assignment_id = $_POST['assignment_id'];
    $action = $_POST['action'];

    try {
        // Verify the task assignment belongs to the logged-in user
        $stmt = $pdo->prepare("
            SELECT ta.id AS assignment_id, ta.task_id, t.status
            FROM task_assignments ta
            JOIN tasks t ON ta.task_id = t.task_id
            WHERE ta.id = :assignment_id AND ta.member_id = :user_id
        ");
        $stmt->execute(['assignment_id' => $assignment_id, 'user_id' => $_SESSION['user_id']]);
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$assignment) {
            $message = "You are not authorized to perform this action.";
            $message_class = "error";
        } else {
            if ($action === 'accept') {
                // Update the task status to "Active"
                $stmt = $pdo->prepare("
                    UPDATE tasks 
                    SET status = 'Active'
                    WHERE task_id = :task_id
                ");
                $stmt->execute(['task_id' => $assignment['task_id']]);

                $message = "Task successfully accepted and activated.";
                $message_class = "success";
            } elseif ($action === 'reject') {
                // Delete the task assignment
                $stmt = $pdo->prepare("
                    DELETE FROM task_assignments
                    WHERE id = :assignment_id
                ");
                $stmt->execute(['assignment_id' => $assignment_id]);

                $message = "Task assignment successfully rejected.";
                $message_class = "success";
            } else {
                $message = "Invalid action requested.";
                $message_class = "error";
            }
        }
    } catch (PDOException $e) {
        $message = "A database error occurred. Please try again later.";
        $message_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Task Details</h1>
    </header>
    <main>
        <!-- Display confirmation or error messages -->
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_class; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>


    </main>
</body>
</html>
