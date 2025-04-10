<?php
    include 'dbconfig.in.php';

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $task_id = $_POST['update_task_id'];

    $query = "SELECT t.task_id, t.task_name, t.progress, t.status 
              FROM tasks t 
              WHERE t.task_id = :task_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':task_id' => $task_id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        echo '<form method="POST" action="">
                <h2>Update Task</h2>
                <div class="form-group">
                    <label for="updateTaskId">Task ID:</label>
                    <input type="text" id="updateTaskId" name="task_id" value="' . htmlspecialchars($task['task_id']) . '" readonly>
                </div>
                <div class="form-group">
                    <label for="progress">Progress:</label>
                    <input type="number" id="progress" name="progress" min="0" max="100" value="' . htmlspecialchars($task['progress']) . '">
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="Pending" ' . ($task['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>
                        <option value="In Progress" ' . ($task['status'] == 'In Progress' ? 'selected' : '') . '>In Progress</option>
                        <option value="Completed" ' . ($task['status'] == 'Completed' ? 'selected' : '') . '>Completed</option>
                    </select>
                </div>
                <button type="submit" name="update">Save Changes</button>
            </form>';
    } else {
        echo '<p>Task not found.</p>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $task_id = $_POST['task_id'];
    $progress = $_POST['progress'];
    $status = $_POST['status'];

    if ($progress == 100) {
        $status = 'Completed';
    } elseif ($progress > 0) {
        $status = 'In Progress';
    } else {
        $status = 'Pending';
    }

    $query = "UPDATE tasks SET progress = :progress, status = :status WHERE task_id = :task_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':progress' => $progress, ':status' => $status, ':task_id' => $task_id]);

    echo '<p>Task updated successfully.</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="action.css">

    <title>Document</title>
</head>
<body>
    
</body>
</html>