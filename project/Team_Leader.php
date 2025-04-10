<?php
require 'dbconfig.in.php'; 


$stmt = $pdo->query("
    SELECT project_id, title, start_date, end_date 
    FROM projects 
    WHERE team_leader_id IS NULL 
    ORDER BY start_date ASC
");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unassigned Projects</title>
    <link rel="stylesheet" type="text/css" href="Team_Leader.css"> 
    
</head>
<header>
        <div class="user-profile">
            <img src="<?php echo $user_photo; ?>" alt="User Photo" class="profile-photo">
            <a href="profile.php" class="user-name"> <?php echo $user_name; ?> </a>
        </div>
        <nav>
            <ul>
                <li><a href="logout.php">sign-up</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h2>Projects Without Team Leader</h2>
    <table>
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['project_id']); ?></td>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['end_date']); ?></td>
                        <td>
                            <a href="Allocate_Team.php?project_id=<?php echo urlencode($project['project_id']); ?>">Allocate Team Leader</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No projects without team leader.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
