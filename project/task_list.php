<?php
require 'dbconfig.in.php'; 

$tasks = $pdo->query("SELECT task_id, task_name, start_date, status, priority FROM tasks")->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Task List</h2>
    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Start Date</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Team Allocation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['task_id']); ?></td>
                    <td><?= htmlspecialchars($task['task_name']); ?></td>
                    <td><?= htmlspecialchars($task['start_date']); ?></td>
                    <td><?= htmlspecialchars($task['status']); ?></td>
                    <td><?= htmlspecialchars($task['priority']); ?></td>
                    <td><a href="assign_team.php?task_id=<?= htmlspecialchars($task['task_id']); ?>">Assign Team Members</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
