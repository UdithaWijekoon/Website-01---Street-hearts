<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if token is valid and not expired
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset_request = $stmt->fetch();

    if ($reset_request && strtotime($reset_request['expires_at']) > time()) {
        if ($password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update the user's password in the admins table
            $stmt = $pdo->prepare('UPDATE admins SET password = ? WHERE email = ?');
            $stmt->execute([$hashed_password, $reset_request['email']]);

            // Delete the password reset request from the table
            $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
            $stmt->execute([$token]);

            $_SESSION['message'] = "Password reset successfully.";
            header("Location: admin_login.php");
        } else {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: admin_reset_password.php?token=$token");
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: admin_forgot_password.php");
    }
}
