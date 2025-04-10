<?php
require 'dbconfig.in.php'; 


$priority = !empty($_GET['priority']) ? $_GET['priority'] : null;
$status = !empty($_GET['status']) ? $_GET['status'] : null;
$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : null;
$project_id = !empty($_GET['project_id']) ? $_GET['project_id'] : null;

$query = "
    SELECT 
        t.task_id,
        t.task_name,
        p.title AS project_title,
        t.status,
        t.priority,
        t.start_date,
        t.end_date,
        t.progress
    FROM 
        tasks t
    JOIN 
        projects p ON t.project_id = p.project_id
    WHERE 1 = 1
";

$params = [];
if ($priority) {
    $query .= " AND t.priority = :priority";
    $params['priority'] = $priority;
}
if ($status) {
    $query .= " AND t.status = :status";
    $params['status'] = $status;
}
if ($start_date) {
    $query .= " AND t.start_date >= :start_date";
    $params['start_date'] = $start_date;
}
if ($end_date) {
    $query .= " AND t.end_date <= :end_date";
    $params['end_date'] = $end_date;
}
if ($project_id) {
    $query .= " AND p.project_id = :project_id";
    $params['project_id'] = $project_id;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Search Results</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Start Date</th>
                    <th>Due Date</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr>
                        <td colspan="8">No tasks found for the given criteria.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr class="priority-<?php echo strtolower($task['priority']); ?>">
                            <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                            <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                            <td><?php echo htmlspecialchars($task['project_title']); ?></td>
                            <td class="status-<?php echo strtolower(str_replace(' ', '-', $task['status'])); ?>">
                                <?php echo htmlspecialchars($task['status']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($task['priority']); ?></td>
                            <td><?php echo htmlspecialchars($task['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['progress']); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
