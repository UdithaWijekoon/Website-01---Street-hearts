<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "street_hearts";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}
// Get form data
$name = $_POST['name'];
$district = $_POST['district'];
$type = $_POST['type'];
$description = $_POST['description'];
$address = $_POST['address'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Insert data into the database
$sql = "INSERT INTO pet_care_locations (name, district, type, description, address, latitude, longitude)
VALUES ('$name', '$district', '$type', '$description', '$address', '$latitude', '$longitude')";

if ($conn->query($sql) === TRUE) {
    echo '<div class="message success">New location added successfully.</div>';
} else {
    echo '<div class="message error">Error: ' . $sql . '<br>' . $conn->error . '</div>';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
.message {
    padding: 10px;
    margin: 20px auto;
    width: 90%;
    max-width: 600px;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Back Link Style */
.back-link {
    display: inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.back-link:hover {
    background-color: #0056b3;
}

/* Center content */
body {
    text-align: center;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}
</style>
<div class="container">
    <a href="javascript:history.back()" class="back-link">←Go Back</a>
</div>
</body>
</html>