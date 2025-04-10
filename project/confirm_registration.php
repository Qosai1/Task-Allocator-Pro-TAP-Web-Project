<?php
session_start();
require 'dbconfig.in.php';

if (!isset($_SESSION['step1_data']) || !isset($_SESSION['step2_data'])) {
    header("Location: information.php");
    exit;
}

$userData = array_merge($_SESSION['step1_data'], $_SESSION['step2_data']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction();

        // Generate a 10-digit user ID
        $userId = rand(1000000, 99999999);

        // Insert into `users` table
        $stmt = $pdo->prepare("
            INSERT INTO users (user_id, name, address, date_of_birth, id_number, email, role, telephone, qualification, skills, username, password)
            VALUES (:user_id, :name, :address, :date_of_birth, :id_number, :email, :role, :telephone, :qualification, :skills, :username, :password)
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':name' => $userData['name'],
            ':address' => $userData['address'],
            ':date_of_birth' => $userData['dob'],
            ':id_number' => $userData['id_number'],
            ':email' => $userData['email'],
            ':role' => $userData['role'],
            ':telephone' => $userData['telephone'],
            ':qualification' => $userData['qualification'],
            ':skills' => $userData['skills'],
            ':username' => $userData['username'],
            ':password' => $userData['password'],
        ]);

        // Role-specific insertion logic
        switch ($userData['role']) {
            case 'Manager':
                // Managers do not have a specific table in the schema
                break;

            case 'Project Leader':
                $stmt = $pdo->prepare("
                    INSERT INTO team_leaders (leader_id, name, email, active)
                    VALUES (:leader_id, :name, :email, :active)
                ");
                $stmt->execute([
                    ':leader_id' => $userId,
                    ':name' => $userData['name'],
                    ':email' => $userData['email'],
                    ':active' => 1,
                ]);
                break;

            case 'Team Member':
                $stmt = $pdo->prepare("
                    INSERT INTO team_members (member_id, name, role, email, contact_number)
                    VALUES (:member_id, :name, :role, :email, :contact_number)
                ");
                $stmt->execute([
                    ':member_id' => $userId,
                    ':name' => $userData['name'],
                    ':role' => $userData['skills'], // Assuming 'skills' is used for role
                    ':email' => $userData['email'],
                    ':contact_number' => $userData['telephone'],
                ]);
                break;
        }

        $pdo->commit();

        $_SESSION['confirmation'] = [
            'user_id' => $userId,
            'username' => $userData['username'],
        ];
        header("Location: registration_success.php");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Confirm Your Registration</h1>
    </header>
    <main>
        <form action="confirm_registration.php" method="POST">
            <h2>Review Your Information</h2>
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="read-only">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['name']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($userData['address']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($userData['dob']); ?></p>
                <p><strong>ID Number:</strong> <?php echo htmlspecialchars($userData['id_number']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($userData['role']); ?></p>
                <p><strong>Telephone:</strong> <?php echo htmlspecialchars($userData['telephone']); ?></p>
                <p><strong>Qualification:</strong> <?php echo htmlspecialchars($userData['qualification']); ?></p>
                <p><strong>Skills:</strong> <?php echo htmlspecialchars($userData['skills']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
            </div>
            <button type="submit">Confirm</button>
        </form>
    </main>
</body>
</html>
