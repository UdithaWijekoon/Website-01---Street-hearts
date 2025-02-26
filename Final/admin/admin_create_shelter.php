<?php
// Database connection
include 'db_connect.php';
session_start();

// Check if the Shelter is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sheltername = $_POST['sheltername'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $district_id = $_POST['district'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO shelters (ShelterName, Address, PhoneNumber, Email, DistrictID, Password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $sheltername, $address, $phone, $email, $district_id, $hashed_password);

    if ($stmt->execute()) {
        echo '<div class="message success">Shelter account created successfully!</div>';
    } else {
        echo '<div class="message error">Error: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Shelter</title>
    <style>
/* Message Styles */
.message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
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

</head>
<body>
<div class="container">
    <a href="javascript:history.back()" class="back-link">←Go Back</a>
</div>
</body>
</html>
