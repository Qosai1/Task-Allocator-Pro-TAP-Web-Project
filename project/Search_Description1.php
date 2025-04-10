<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Search Tasks</h1>
    </header>
    <main>
        <form action="Search_Description.php" method="get">
            <label for="priority">Priority:</label>
            <select id="priority" name="priority">
                <option value="">All</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">

            <label for="<?php echo htmlspecialchars($project['id']); ?>">Project:</label>
            <select id="<?php echo htmlspecialchars($project['id']); ?>"name="<?php echo htmlspecialchars($project['id']); ?>">
                <option value="">All Projects</option>
                <!-- Dynamically load projects from the database -->
                 <?php
                 require 'dbconfig.in.php'; // Database connection

                 $projects_stmt = $pdo->query("SELECT id, title FROM projects WHERE 1 = 1");
                 $projects = $projects_stmt->fetchAll(PDO::FETCH_ASSOC);
                 ?>
                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo htmlspecialchars($project['id']); ?>">
                        <?php echo htmlspecialchars($project['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </select>

            <button type="submit">Search</button>
        </form>
    </main>
</body>
</html>
