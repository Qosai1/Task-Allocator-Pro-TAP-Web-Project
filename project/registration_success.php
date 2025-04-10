<?php
session_start();
if (!isset($_SESSION['confirmation'])) {
    header("Location: register_step1.php");
    exit;
}

$confirmation = $_SESSION['confirmation'];
unset($_SESSION['step1'], $_SESSION['step2'], $_SESSION['confirmation']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Registration Complete</h1>
    </header>
    <main>
        <h2>Success!</h2>
        <p>Your registration is complete.</p>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($confirmation['user_id']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($confirmation['username']); ?></p>
        <p><a href="login.php">Click here to log in</a></p>
    </main>
</body>
</html>
