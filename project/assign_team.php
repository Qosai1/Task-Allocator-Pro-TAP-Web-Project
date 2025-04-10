<?php
require 'dbconfig.in.php'; // Database connection


$task_id = $_GET['task_id'] ?? '';
$error = '';
$success = '';

// Fetch task details
$task = $pdo->prepare("SELECT task_id, task_name, start_date FROM tasks WHERE task_id = :task_id");
$task->execute([':task_id' => $task_id]);
$task = $task->fetch();

// Fetch team members
$members = $pdo->query("SELECT member_id, name FROM team_members")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $role = $_POST['role'];
    $contribution_percentage = $_POST['contribution_percentage'];
    $start_date = $_POST['start_date'];

   
        try {
            // Insert assignment into the database
            $stmt = $pdo->prepare("INSERT INTO task_assignments (task_id, member_id, role, contribution_percentage, start_date) 
                                   VALUES (:task_id, :member_id, :role, :contribution_percentage, :start_date)");
            $stmt->execute([
                ':task_id' => $task_id,
                ':member_id' => $member_id,
                ':role' => $role,
                ':contribution_percentage' => $contribution_percentage,
                ':start_date' => $start_date,
            ]);
            $success = "Team member successfully assigned 
            Task==>[". htmlspecialchars($task['task_id']) ."]as [$role]";
            
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
    <title>Assign Team Members</title>
    <link rel="stylesheet" href="assign_team.css">
</head>
<body>
    <h2>Assign Team Members to Task</h2>

    <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success); ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
    <p><strong>Task ID:</strong> <?= htmlspecialchars($task['task_id']); ?></p>
    <p><strong>Task Name:</strong> <?= htmlspecialchars($task['task_name']); ?></p>

    <label for="member_id">Team Member:</label>
    <select id="member_id" name="member_id" required>
        <option value="">Select a Team Member</option>
        <?php foreach ($members as $member): ?>
            <option value="<?= htmlspecialchars($member['member_id']); ?>">
                <?= htmlspecialchars($member['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="Developer">Developer</option>
        <option value="Designer">Designer</option>
        <option value="Tester">Tester</option>
        <option value="Analyst">Analyst</option>
    </select>

    <label for="contribution_percentage">Contribution Percentage:</label>
    <input type="number" id="contribution_percentage" name="contribution_percentage" min="1" max="100" required>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>

    <div class="button-group">
        <button type="submit" class="primary">Assign Team Member</button>
    
        <a href="task_list.php" class="finish">Finish Allocation</a>
    </div>
</form>


</body>
</html>
