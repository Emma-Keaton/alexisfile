<?php
// Start session
session_start();
include("connection.php"); // Ensure connection.php connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from user input
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Debugging: Check if email and password have values
    if (empty($email) || empty($password)) {
        echo "Please fill all fields.";
        exit();
    }

    // Check if $pdo is defined
    if (!isset($pdo)) {
        die("Database connection is not established.");
    }

    // Check if the email already exists in the database
    $sql = "SELECT * FROM otp_table WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the user does not exist, create a new user
    if (!$user) {
        // Insert the email and plain password into the database
        $insertQuery = "INSERT INTO otp_table (email, password) VALUES (:email, :password)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute(['email' => $email, 'password' => $password]);

        echo "New user created. Email: $email<br>";
    }

    // Store email in session
    $_SESSION['email'] = $email;

    // Generate a random 6-digit OTP
    $otp = rand(100000, 999999);

    // Store OTP in the session for later use
    $_SESSION['otp'] = $otp;

    // Store OTP in the database
    // $insertOtpQuery = "UPDATE otp_table SET otp = :otp WHERE email = :email";
    // $otpStmt = $pdo->prepare($insertOtpQuery);
    // $otpStmt->execute(['otp' => $otp, 'email' => $email]);

    // Redirect to OTP verification page
    header("Location: otp_verification.php");
    exit();
} else {
    // Redirect to login if accessed directly
    header("Location: login.php");
    exit();
}