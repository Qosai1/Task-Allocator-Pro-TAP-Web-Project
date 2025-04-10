<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Search and Update</title>
    <link rel="stylesheet" href="search.css">

</head>
<body>
    <h1>Task Search and Update</h1>

    <form method="POST" action="Update.php">
        <div class="form-group">
            <label for="taskId">Task ID:</label>
            <input type="text" id="taskId" name="task_id">
        </div>
        <div class="form-group">
            <label for="taskName">Task Name:</label>
            <input type="text" id="taskName" name="task_name">
        </div>
        <div class="form-group">
            <label for="projectName">Project Name:</label>
            <input type="text" id="projectName" name="project_name">
        </div>
        <button type="submit" name="search">Search</button>
    </form> 
    </body>
</html>