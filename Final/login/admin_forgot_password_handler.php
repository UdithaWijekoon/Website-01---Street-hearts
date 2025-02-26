<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token and expiration time
        $token = bin2hex(random_bytes(50));
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store the token and expiration time in the database
        $stmt = $pdo->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$email, $token, $expires_at]);

        // Send the reset link via email
        $reset_link = "http://localhost/final/login/admin_reset_password.php?token=$token";
        $subject = "Admin Password Reset Request";

        // HTML email content
        $message = "
        <html>
        <head>
            <title>Password Reset Request</title>
        </head>
        <body>
            <h2>Password Reset Request</h2>
            <p>We received a request to reset your password. If you didn't request this, please ignore this email.</p>
            <p>If you did request a password reset, click the link below to reset your password:</p>
            <a href='$reset_link' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none;'>Reset Password</a>
            <p>Or copy and paste the following URL into your browser:</p>
            <p><a href='$reset_link'>$reset_link</a></p>
            <p><strong>Note:</strong> This link will expire in 1 hour.</p>
            <p>Thank you,<br>Street Hearts Team</p>
        </body>
        </html>
        ";

        // To send HTML mail, set content-type header
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: no-reply@streethearts.com' . "\r\n";
        mail($email, $subject, $message, $headers);

        $_SESSION['message'] = "Password reset link sent to your email.";
    } else {
        $_SESSION['error'] = "No Admin account found with that email address.";
    }
}

// Display messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        .success {
            background-color: #28a745;
        }
        .error {
            background-color: #dc3545;
        }
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<a href="admin_login.php" class="back-button">Back</a>

</body>
</html>
