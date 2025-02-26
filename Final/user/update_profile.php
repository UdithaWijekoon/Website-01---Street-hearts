<?php
include 'db.php';
session_start();

// Fetch UserID from session
$userID = $_POST['userID'] ?? null;

// Redirect to login if not logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !$userID) {
    header("Location: ../login/user_login.php");
    exit();
}

$message = '';
$status = '';

try {
    // Fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = :UserID");
    $stmt->execute(['UserID' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ensure user data is fetched
    if (!$user) {
        throw new Exception("User not found.");
    }

    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate username and email
    if (empty($username)) {
        throw new Exception("Error: Username is required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Error: Invalid email format.");
    }

    // Check if the user is changing the password
    if (!empty($newPassword)) {
        // Check if new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            throw new Exception("Error: New passwords do not match.");
        }

        // Hash the new password
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    } else {
        // Keep the old password if not changing
        $passwordHash = $user['PasswordHash'];
    }

    // Handle profile picture upload
    $profilePicturePath = $user['ProfilePicture'];
    if (!empty($_FILES['profilePicture']['name'])) {
        $targetDir = "../uploads/profile_pictures/";
        $profilePicturePath = $targetDir . basename($_FILES["profilePicture"]["name"]);
        move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $profilePicturePath);
    }

    // Update user details
    $stmt = $pdo->prepare("UPDATE users SET Username = :username, Email = :email, PasswordHash = :passwordHash, ProfilePicture = :profilePicture WHERE UserID = :userID");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'passwordHash' => $passwordHash,
        'profilePicture' => $profilePicturePath,
        'userID' => $userID
    ]);

    $message = "Profile updated successfully!";
    $status = "success";
} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 18px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="message <?php echo $status; ?>">
    <?php echo $message; ?>
</div>

<a href="javascript:void(0);" onclick="goBack()" class="back-button">Back</a>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
