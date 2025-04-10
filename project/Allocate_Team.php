<?php
require 'dbconfig.in.php'; // Database connection


// Get project ID from query parameters
if (!isset($_GET['project_id'])) {
    die("Project ID is required.");
}
$project_id = $_GET['project_id'];

// Fetch project details
$stmt = $pdo->prepare("SELECT * FROM projects WHERE project_id = :project_id");
$stmt->execute(['project_id' => $project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    die("Project not found.");
}

// Fetch available team leaders
$leaders_stmt = $pdo->query("SELECT leader_id, name FROM team_leaders WHERE active = 1");
$team_leaders = $leaders_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch supporting documents
$docs_stmt = $pdo->prepare("SELECT document_title, document_path FROM project_documents WHERE project_id = :project_id");
$docs_stmt->execute(['project_id' => $project_id]);
$documents = $docs_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Team Leader</title>
    <link rel="stylesheet" type="text/css" href="Allocate_Team.css">
   
</head>
<body>
    <h2>Allocate Team Leader</h2>
    <form action="allocate_team_leader_action.php" method="POST">
        <fieldset>
            <legend>Project Details</legend>
            <label for="project_id">Project ID:</label>
            <input type="text" id="project_id" name="project_id" value="<?php echo htmlspecialchars($project['project_id']); ?>" readonly>

            <label for="title">Project Title:</label>
            <input type="text" id="title" value="<?php echo htmlspecialchars($project['title']); ?>" readonly>

            <label for="description">Description:</label>
            <textarea id="description" readonly><?php echo htmlspecialchars($project['description']); ?></textarea>

            <label for="customer">Customer Name:</label>
            <input type="text" id="customer" value="<?php echo htmlspecialchars($project['customer']); ?>" readonly>

            <label for="budget">Total Budget:</label>
            <input type="text" id="budget" value="<?php echo htmlspecialchars($project['budget']); ?>" readonly>

            <label for="start_date">Start Date:</label>
            <input type="text" id="start_date" value="<?php echo htmlspecialchars($project['start_date']); ?>" readonly>

            <label for="end_date">End Date:</label>
            <input type="text" id="end_date" value="<?php echo htmlspecialchars($project['end_date']); ?>" readonly>
        </fieldset>

        <fieldset>
            <legend>Select Team Leader</legend>
            <label for="team_leader">Team Leader:</label>
            <select name="team_leader_id" id="team_leader" required>
                <option value="">-- Select Team Leader --</option>
                <?php foreach ($team_leaders as $leader): ?>
                    <option value="<?php echo htmlspecialchars($leader['leader_id']); ?>">
                        <?php echo htmlspecialchars($leader['name'] . ' - ' . $leader['leader_id']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <button type="submit">Confirm Allocation</button>
    </form>

    <div class="documents">
    <h3>Supporting Documents</h3>
    <?php if (!empty($documents)): ?>
        <ul>
            <?php foreach ($documents as $doc): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($doc['document_path']); ?>" target="_blank" class="doc-link">
                        <span class="icon-doc"></span>
                        <?php echo htmlspecialchars($doc['document_title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No supporting documents available.</p>
    <?php endif; ?>
</div>

</body>
</html>
