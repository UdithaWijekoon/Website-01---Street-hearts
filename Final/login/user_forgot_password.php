<!-- forgot_password.php -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Forgot Your Password?</h2>
    <p>Enter your email to reset your password.</p>

    <form action="user_forgot_password_handler.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>

    <!-- Back to Login button -->
    <div class="mt-3">
        <a href="user_login.php" class="btn btn-secondary">Back to Login</a>
    </div>
    
</div>

</body>
</html>
