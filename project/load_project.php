<?php
    include 'dbconfig.in.php';

// Fetch projects
$sql = "SELECT id, title FROM projects";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output each project as an option
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['title']) . '</option>';
    }
} else {
    echo '<option value="">No projects available</option>';
}
?>
