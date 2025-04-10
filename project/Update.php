
<?php
    include 'dbconfig.in.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
        $task_id = $_POST['task_id'] ?? '';
        $task_name = $_POST['task_name'] ?? '';
        $project_name = $_POST['project_name'] ?? '';

        $query = "SELECT t.task_id, t.task_name, t.description, t.progress, t.status, p.title AS project_name 
                  FROM tasks t 
                  JOIN projects p ON t.project_id = p.project_id 
                  WHERE 1=1";
        $params = [];

        if ($task_id) {
            $query .= " AND t.task_id LIKE :task_id";
            $params[':task_id'] = "%$task_id%";
        }
        if ($task_name) {
            $query .= " AND t.task_name LIKE :task_name";
            $params[':task_name'] = "%$task_name%";
        }
        if ($project_name) {
            $query .= " AND p.title LIKE :project_name";
            $params[':project_name'] = "%$project_name%";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tasks) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Project Name</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($tasks as $task) {
                echo '<tr>
                        <td>' . htmlspecialchars($task['task_id']) . '</td>
                        <td>' . htmlspecialchars($task['task_name']) . '</td>
                        <td>' . htmlspecialchars($task['project_name']) . '</td>
                        <td>' . htmlspecialchars($task['progress']) . '%</td>
                        <td>' . htmlspecialchars($task['status']) . '</td>
                        <td>
                            <form method="POST" action="Action.php">
                                <input type="hidden" name="update_task_id" value="' . htmlspecialchars($task['task_id']) . '">
                                <button type="submit" name="edit">Edit</button>
                            </form>
                        </td>
                    </tr>';
            }
            echo '</tbody>
                </table>';
        } else {
            echo '<p>No tasks found.</p>';
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link rel="stylesheet" href="update.css">
    </head>
 
      
    </body>
    </html>
    