<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the session
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role']; // Manager, Project Leader, or Team Member
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>
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

    <main>
        <h2> <?php echo $role; ?></h2>

        <!-- Manager Dashboard -->
        <?php if ($role === 'Manager'): ?>
            <section>
                <h3>Manager Functions</h3>
                <ul>
                    <li><a href="Add Project.php">Add Project</a></li>
                    <li><a href="Team_Leader.php">Allocate Team Leader</a></li>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Project Leader Dashboard -->
        <?php if ($role === 'Project Leader'): ?>
            <section>
                <h3>Project Leader Functions</h3>
                <ul>
                    <li><a href="task_creation.php">Create Task</a></li>
                    <li><a href="task_list.php">Task List</a></li>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Team Member Dashboard -->
        <?php if ($role === 'Team Member'): ?>
            <section>
                <h3>Team Member Functions</h3>
                <ul>
                    <li><a href="Accept_task.php">Assignments</a></li>
                    <li><a href="Search.php">  Search and Update Task Progress</a></li>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Common Features for All Users -->
        <section>
            <h3>Common Functions</h3>
            <ul>
                <li><a href="Search_Description1.php">Search Tasks</a></li>
                <li><a href="task_details.php">View Task Details</a></li>
            </ul>
        </section>
    </main>

    <footer>
    <div class="footer">
        <p>&copy; 2025 Task Allocator Pro. All rights reserved.</p>
        <p>Last Update: Jan 1, 2025</p>
        <p> Address: Ramallah/Deir Ammar</p>
        <p>Customer Support: Phone: +0597698941 | Email: qosaibadaha26@gmail.com</p>
        <p> <a href="Contact.html">Contact us</a></p>
 
    </footer>
</footer>

</body>
</html>
