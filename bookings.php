<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $car = isset($_POST['car']) ? $_POST['car'] : '';

// val email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit;
    }

  // Val phono
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<script>alert('Invalid phone number format. It should be a 10-digit number.'); window.history.back();</script>";
        exit;
    }

 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (name, phone, email, location, date, time, car) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $bind = $stmt->bind_param("sssssss", $name, $phone, $email, $location, $date, $time, $car);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

   
    $execute = $stmt->execute();
    if ($execute === false) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo "<script>alert('Booking successful.'); window.location.href = 'home.html';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
