<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the shelters table
    $stmt = $pdo->prepare('SELECT * FROM shelters WHERE email = ?');
    $stmt->execute([$email]);
    $shelter = $stmt->fetch();

    if ($shelter) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Set token expiration (1 hour)
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store the token in the password_resets table
        $stmt = $pdo->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$email, $token, $expires_at]);

        // Send reset link to email
        $reset_link = "http://localhost/final/login/shelter_reset_password.php?token=$token";
        $subject = "Shelter Password Reset Request";
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

        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['message'] = "Password reset link sent to your email.";
        } else {
            $_SESSION['error'] = "Failed to send reset email. Please try again later.";
        }

    } else {
        $_SESSION['error'] = "No Shelter account found with that email.";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        .alert-success {
            background-color: #28a745;
        }
        .alert-danger {
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
        <div class="alert alert-success">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
<?php endif; ?>

<a href="shelter_login.php" class="back-button">Back</a>

</body>
</html>
