<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if(empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO login_details (email, password) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $bind = $stmt->bind_param("ss", $email, $password);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the statement
    $execute = $stmt->execute();
    if ($execute === false) {
        die("Execute failed: " . $stmt->error);
    } else {
                    echo "<script>alert('Login successful.'); window.location.href = 'home.html';</script>";
                 

 }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
