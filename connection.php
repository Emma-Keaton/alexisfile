<?php
    // Enable error reporting for debugging (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if both email and password are set
        if (isset($_POST['email']) && isset($_POST['passWord'])) {
            $email = $_POST['email'];
            $password = $_POST['passWord'];

            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password_db = "";  // MySQL password
            $dbname = "robinhood";

            // Create connection
            $conn = new mysqli($servername, $username, $password_db, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            // Prepare and bind (assuming you're inserting into the database)
            $stmt = $conn->prepare("INSERT INTO registration (email, password) VALUES (?, ?)");
            if (!$stmt) {
                die("Error in preparing statement: " . $conn->error);
            }
            $stmt->bind_param("ss", $email, $password);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the connection
            $stmt->close();
            $conn->close();
        } else {
            echo '<p style="color: red;">Please fill in both email and password.</p>';
        }
    }
    ?>

