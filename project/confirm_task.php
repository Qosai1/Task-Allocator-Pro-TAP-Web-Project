<?php
require 'dbconfig.in.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate the task_id parameter
if (!isset($_GET['task_id'])) {
    header("Location: tasks.php?error=invalid_task");
    exit();
}

$task_id = $_GET['task_id'];
$user_id = $_SESSION['user_id'];

try {
    // Fetch task details for the logged-in user
    $stmt = $pdo->prepare("
        SELECT 
            t.task_id,
            t.task_name,
            t.description,
            t.priority,
            t.status,
            t.effort,
            ta.role,
            t.start_date,
            t.end_date,
            ta.id AS assignment_id
        FROM 
            tasks t
        JOIN 
            task_assignments ta ON t.task_id = ta.task_id
        WHERE 
            t.task_id = :task_id AND ta.member_id = :user_id
    ");
    $stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        header("Location: tasks.php?error=task_not_found");
        exit();
    }
} catch (PDOException $e) {
    // Handle database error
    header("Location: tasks.php?error=database_error");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Confirmation</title>
    <link rel="stylesheet" href="confirm_task.css">
</head>
<body>
    <header>
        <h1>Task Confirmation</h1>
    </header>
    <main>
        <div class="task-details">
            <h2>Task Details</h2>
            <p><strong>Task ID:</strong> <?php echo htmlspecialchars($task['task_id']); ?></p>
            <p><strong>Task Title:</strong> <?php echo htmlspecialchars($task['task_name']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
            <p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
            <p><strong>Total Effort:</strong> <?php echo htmlspecialchars($task['effort']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($task['role']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($task['start_date']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($task['end_date']); ?></p>

            <form action="task_action.php" method="post" class="action-buttons">
                <input type="hidden" name="assignment_id" value="<?php echo htmlspecialchars($task['assignment_id']); ?>">
                <button type="submit" name="action" value="accept" class="btn btn-accept">Accept Task</button>
                <button type="submit" name="action" value="reject" class="btn btn-reject">Reject Task</button>
            </form>
        </div>
    </main>
</body>
</html>
