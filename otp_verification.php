<?php
// Start session
session_start();

// Ensure the email and OTP are set in the session
if (!isset($_SESSION['email']) /**|| !isset($_SESSION['otp'])/** */) {
    // If not, redirect back to the login page
    header("Location: login.php");
    exit();
}

// Get the email and OTP from the session
$email = $_SESSION['email'];
// $otp_sent = $_SESSION['otp']; // Get the OTP sent to the user

include("connection.php"); // Ensure connection.php connects to your database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background-color: rgb(3, 2, 2); }
        .container { max-width: 400px; margin: auto; text-align: center; color: #fff;}
        .otp-input { width: 250px; padding: 10px; font-size: 20px; text-align: border:1px solid #fff; text-align: center; background-color: black; color: #fff;}
        .verifyButton { padding: 18px 20px; background-color: rgb(26, 25, 25); width: 300px; color: #fff; border: none; cursor: pointer; border-radius: 10px;}
        .otp-group { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h2>Enter your Verification Code</h2>
            <p>A verification code has been sent to <strong><?php echo $email; ?></strong></p>
        </div>

        <!-- OTP Form -->
        <form id="otpForm" action="otp_verification.php" method="POST">
            <div class="otp-form">
                <p>Enter the 6-digit code we sent to you via email to continue</p>
                <div class="otp-group">
                    <input type="text" name="otp_input" maxlength="6" class="otp-input" placeholder="XXXXXX" required>
                </div><br><br><br>
                <button type="submit" class="verifyButton">Continue</button>
            </div>
        </form>

    </div>

    <?php

    // Check if OTP form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $otp_entered = $_POST['otp_input'] ?? '';

       // Validate OTP (must be 6 digits)
       if (preg_match('/^[0-9]{6}$/', $otp_entered)) {
        // Store the user's input OTP in the database
        $sql = "UPDATE otp_table SET otp = :otp WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['otp' => $otp_entered, 'email' => $email]);

        echo "<p style='color:green'>OTP has been successfully saved.</p>";

        // Optionally, redirect to a confirmation page
        header("Location: congratulations.php");
        exit();
    } else {
        echo "<p style='color:red'>Please enter a valid 6-digit OTP.</p>";
    }
}
    ?>
</body>
</html>
