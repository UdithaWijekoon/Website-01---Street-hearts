<?php
// Include the database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Handle profile picture upload
    $profilePicturePath = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $targetDir = "../uploads/profile_pictures/";
        $profilePicturePath = $targetDir . basename($_FILES['profile_picture']['name']);
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePicturePath)) {
            die("Failed to upload profile picture.");
        }
    }

    // Insert user into the database
    $sql = "INSERT INTO users (Username, PasswordHash, Email, PhoneNumber, Address, ProfilePicture) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("ssssss", $username, $password, $email, $phone, $address, $profilePicturePath);

    if ($stmt->execute()) {
        $message = "User account created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
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
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message-container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .message-container h1 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .message-container p {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }

        .message-container .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .message-container .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="message-container">
    <h1><?php echo $message; ?></h1>
    <p>Your account has been created. You can now log in and start using the platform.</p>
    <a href="../login/user_login.php" class="back-button">Back to Login</a>
</div>

</body>
</html>
