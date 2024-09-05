<?php
session_start();
include("connection.php");

// Validate user login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['passWord'];

    // Query to check user credentials (example only)
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Set session variables for user login
        $_SESSION['email'] = $email;
        
        // Redirect to OTP verification
        header("Location: otp.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>
