<?php
// Start the session
session_start();
$logo_path = "images/download-removebg-preview.png";

include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/download-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="login-container">
    <img src="<?php echo $logo_path; ?>" alt="Logo" class="logo">
    
    <!-- Login Form with Email and Password -->
    <form action="login_action.php" class="login-form" method="POST">
        <div class="input-group">
            <input type="email" name="email" id="email" placeholder="Email" required>
            <span class="error-message" id="email-error"></span>
        </div>
        <div class="input-group password-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">
              <i class="fas fa-eye-slash"></i>
              <!-- < id="toggleIcon" -->
            </span>
            <span class="error-message" id="password-error"></span>
        </div> <br/> <br/> <br/>
        <button type="submit" class="login-button">Log in</button>
    </form>
    
    <div class="help-dropdown">
        <button class="dropdown-button">I need help</button>
        <div class="dropdown-content">
            <a href="#">Forgot your password?</a>
            <a href="#">Forgot your email address?</a>
            <a href="#">Something else</a>
            <a href="#">Cancel</a>
        </div>
    </div>
    <!-- Link to OTP Login -->
    <!-- <p>Or login using <a href="send_otp.php">OTP</a></p> -->
</div>
<script src="login.js"></script>

</body>
</html>
