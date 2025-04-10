<?php
session_start();
require 'dbconfig.in.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = trim($_POST['project_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $customer = trim($_POST['customer']);
    $budget = trim($_POST['budget']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);

    try {
        $stmt = $pdo->prepare("INSERT INTO projects (project_id, title, description, customer, budget, start_date, end_date) VALUES (:project_id, :title, :description, :customer, :budget, :start_date, :end_date)");
        $stmt->execute([
            'project_id' => $project_id,
            'title' => $title,
            'description' => $description,
            'customer' => $customer,
            'budget' => $budget,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        if (!empty($_FILES['documents']['name'][0])) {
            $document_titles = explode(',', trim($_POST['doc_titles']));
            foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['documents']['name'][$key];
                $file_tmp = $_FILES['documents']['tmp_name'][$key];
                $document_title = $document_titles[$key] ?? "Document";

                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_path = $upload_dir . basename($file_name);
                move_uploaded_file($file_tmp, $file_path);

                $stmt = $pdo->prepare("INSERT INTO project_documents (project_id, document_title, document_path) VALUES (:project_id, :document_title, :document_path)");
                $stmt->execute([
                    'project_id' => $project_id,
                    'document_title' => trim($document_title),
                    'document_path' => $file_path,
                ]);
            }
        }

        $success = "Project successfully added.";
    } catch (Exception $e) {
        $error = "An error occurred: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" type="text/css" href="Add_project.css">
</head>
<body>

    <div class="form-container">
        <h2>Add New Project</h2>

        <?php if ($success): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px;">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php elseif ($error): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="Dashboard.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="project_id">Project ID:</label>
                <input type="text" id="project_id" name="project_id" placeholder="e.g., ABCD-12345" required pattern="[A-Z]{4}-\d{5}" title="Must start with 4 uppercase letters, a dash (-), and 5 digits">
            </div>
            <div>
                <label for="title">Project Title:</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="description">Project Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div>
                <label for="customer">Customer Name:</label>
                <input type="text" name="customer" id="customer" required>
            </div>
            <div>
                <label for="budget">Budget:</label>
                <input type="number" name="budget" id="budget" min="0" required>
            </div>
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" required onchange="document.getElementById('end_date').setAttribute('min', this.value)">
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" required>
            </div>
            <div>
                <label for="documents">Supporting Documents (up to 3):</label>
                <input type="file" name="documents[]" id="documents" multiple accept=".pdf,.docx,.png,.jpg">
            </div>
            <div>
                <label for="doc_titles">Document Titles (comma-separated for each file):</label>
                <input type="text" name="doc_titles" id="doc_titles" placeholder="E.g., Contract, Design, Budget">
            </div>
            <button type="submit">Add Project</button>
        </form>
    </div>
</body>
</html>
