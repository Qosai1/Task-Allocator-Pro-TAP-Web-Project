<?php
require 'dbconfig.in.php'; 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch tasks assigned to the user
$stmt = $pdo->prepare("
    SELECT 
        ta.id AS assignment_id,
        t.task_id,
        t.task_name,
        p.title AS project_name,
        t.start_date
    FROM 
        task_assignments ta
    JOIN 
        tasks t ON ta.task_id = t.task_id
    JOIN
        projects p ON t.project_id = p.project_id
    WHERE 
        ta.member_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <link rel="stylesheet" href="accept_task.css">
</head>
<body>
    <header>
        <h1>My Tasks</h1>
    </header>
    <main>
        <table class="task-list">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Project Name</th>
                    <th>Start Date</th>
                    <th>Confirm</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                            <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                            <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                            <td><?php echo htmlspecialchars($task['start_date']); ?></td>
                            <td>
                                <a href="confirm_task.php?task_id=<?php echo $task['task_id']; ?>" class="confirm-link">
                                    Confirm
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No tasks assigned.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
