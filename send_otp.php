<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "otp_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Retrieve the OTP from the data
$otp = $data['otp'];

// Insert OTP into the database
$sql = "INSERT INTO otp_verifications (otp_code) VALUES ('$otp')";

if ($conn->query($sql) === TRUE) {
    // OTP inserted successfully
    echo json_encode(['success' => true]);
} else {
    // Error inserting OTP
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

// Close the connection
$conn->close();

//next page
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = $_POST['otp']; // Assuming OTP is stored and compared here

    // Simple example of OTP validation
    if ($otp_input == "123456") { // Hardcoded OTP for testing
        header("Location: congratulations.php");
        exit();
    } else {
        echo "Invalid OTP.";
    }
}


?>
