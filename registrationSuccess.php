<?php
session_start();

if (!isset($_SESSION['registration_success']) || !$_SESSION['registration_success']) {
    header("Location: index.html");
    exit();
}

unset($_SESSION['registration_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>
<body>
    <h1>Registration Successful</h1>
    <p>Thank you for registering on the e-learning platform. You can now log in to access the courses.</p>
</body>
</html>
