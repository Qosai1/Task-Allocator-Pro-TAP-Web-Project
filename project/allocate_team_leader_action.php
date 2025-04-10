<?php
require 'dbconfig.in.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $team_leader_id = $_POST['team_leader_id'];

    if (empty($team_leader_id)) {
        echo "<div style='color: red; font-weight: bold;'>Error: Please select a team leader.</div>";
        exit();
    }

    try {
        // Update project with the selected team leader
        $stmt = $pdo->prepare("UPDATE projects SET team_leader_id = :team_leader_id WHERE project_id = :project_id");
        $stmt->execute([
            'team_leader_id' => $team_leader_id,
            'project_id' => $project_id,
        ]);

        echo "<div style='color: green; font-weight: bold;'>Team Leader successfully allocated to Project {$project_id}.</div>";
    } catch (Exception $e) {
        echo "<div style='color: red; font-weight: bold;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
