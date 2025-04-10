<?php
require 'dbconfig.in.php'; 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header>
        <h1>User Profile</h1>
        <a href="Dashboard.php" class="logout">Home</a>

        <a href="logout.php" class="logout">Logout</a>
    </header>
    <main>
        <section class="profile">
            
            <div class="profile-details">
                <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['telephone']); ?></p>
                <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Task Allocator Pro. All rights reserved.</p>
    </footer>
</body>
</html>
