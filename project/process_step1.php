<?php
session_start();

$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['name'] = trim($_POST['name']);
  $data['address'] = trim($_POST['flat']) . ', ' .
                   trim($_POST['street']) . ', ' .
                   trim($_POST['city']) . ', ' .
                   trim($_POST['country']);
    $data['dob'] = trim($_POST['dob']);
    $data['id_number'] = trim($_POST['id_number']);
    $data['email'] = trim($_POST['email']);
    $data['telephone'] = trim($_POST['telephone']);
    $data['role'] = trim($_POST['role']);
    $data['qualification'] = trim($_POST['qualification']);
    $data['skills'] = trim($_POST['skills']);

 

   
    if (empty($errors)) {
        $_SESSION['step1_data'] = $data;
        header("Location: E Account.html");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $data;
        header("Location: information.html");
        exit();
    }
}
?>
