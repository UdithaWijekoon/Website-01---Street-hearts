<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the token is valid and not expired
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset_request = $stmt->fetch();

    if ($reset_request && strtotime($reset_request['expires_at']) > time()) {
        if ($password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update the shelter's password in the shelters table
            $stmt = $pdo->prepare('UPDATE shelters SET password = ? WHERE email = ?');
            $stmt->execute([$hashed_password, $reset_request['email']]);

            // Delete the password reset request
            $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
            $stmt->execute([$token]);

            $_SESSION['message'] = "Password reset successfully.";
            header("Location: shelter_login.php");
        } else {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: shelter_reset_password.php?token=$token");
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: shelter_forgot_password.php");
    }
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $_SESSION['error'] = "No token provided.";
    header("Location: shelter_forgot_password.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-primary{
            background-color: #19B340;
            border: none;
        }
        .btn-primary:hover{
            background-color: #088928;
            border: none;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Reset Your Password</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>

</body>
</html>
