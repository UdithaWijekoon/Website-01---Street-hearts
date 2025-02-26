<?php
include 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get user details
    $stmt = $pdo->prepare("SELECT UserID, PasswordHash FROM users WHERE Username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['PasswordHash'])) {
        // Set session variables
        $_SESSION['user_logged_in'] = true;
        $_SESSION['UserID'] = $user['UserID']; // Set the UserID in the session
        $_SESSION['login_message'] = "Login successful!";
        $_SESSION['login_message_type'] = "success";

        header("Location: ../user/index.php"); // Redirect to user dashboard or wherever needed
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
