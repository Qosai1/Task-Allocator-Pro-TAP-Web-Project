<?php
session_start();
require 'dbconfig.in.php'; // Database connection



$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form Inputs
    $task_id = trim($_POST['task_id']);
    $task_name = trim($_POST['task_name']);
    $description = trim($_POST['description']);
    $project_id = trim($_POST['project_id']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $effort = trim($_POST['effort']);
    $status = trim($_POST['status']);
    $priority = trim($_POST['priority']);

    try {
        // Fetch project dates
        $project_stmt = $pdo->prepare("SELECT start_date, end_date FROM projects WHERE project_id = :project_id");
        $project_stmt->execute([':project_id' => $project_id]);
        $project_dates = $project_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$project_dates) {
            throw new Exception("Project not found.");
        }

        $project_start_date = $project_dates['start_date'];
        $project_end_date = $project_dates['end_date'];

        // Validate task dates
        if ($start_date < $project_start_date) {
            throw new Exception("Task start date cannot be earlier than the project's start date ({$project_start_date}).");
        }

        if ($end_date > $project_end_date) {
            throw new Exception("Task end date cannot exceed the project's end date ({$project_end_date}).");
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO tasks (task_id, task_name, description, project_id, start_date, end_date, effort, status, priority) 
                               VALUES (:task_id, :task_name, :description, :project_id, :start_date, :end_date, :effort, :status, :priority)");
        $stmt->execute([
            ':task_id' => $task_id,
            ':task_name' => $task_name,
            ':description' => $description,
            ':project_id' => $project_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':effort' => $effort,
            ':status' => $status,
            ':priority' => $priority,
        ]);
        $success = "Task [$task_name] successfully created.";
        header("Location: task_list.php");
        exit;
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="task_creation.css">
</head>
<body>
    <div class="form-container">
        <h2>Create Task</h2>

        <!-- Display Success or Error Message -->
        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success); ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="task_id">Task ID:</label>
            <input type="text" id="task_id" name="task_id" required>

            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="project_id">Project:</label>
            <select id="project_id" name="project_id" required>
                <?php
                // Fetch projects from the database
                $projects = $pdo->query("SELECT project_id, title FROM projects")->fetchAll();
                foreach ($projects as $project) {
                    echo "<option value='{$project['project_id']}'>{$project['title']}</option>";
                }
                ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="effort">Effort (in man-months):</label>
            <input type="number" id="effort" name="effort" min="0" step="0.1" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="priority">Priority:</label>
            <select id="priority" name="priority" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            <button type="submit">Create Task</button>
        </form>
    </div>
</body>
</html>
