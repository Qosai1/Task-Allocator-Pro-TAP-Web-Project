<?php
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    

    if (empty($errors)) {
        $_SESSION['step2_data'] = [
            'username' => $username,
            'password' => $password, 
        ];
        header("Location: confirm_registration.php");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: E Account.html");
        exit();
    }
} else {
    header("Location: E Account.html");
    exit();
}
