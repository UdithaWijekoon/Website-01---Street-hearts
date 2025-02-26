<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Terms and Conditions</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex-direction: column;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>User Terms and Conditions</h1>
    <p>Please read these Terms and Conditions carefully before using the website or its services.</p>

    <h2>1. Acceptance of Terms</h2>
    <p>By accessing and using this platform, you accept and agree to be bound by the terms and provisions of this agreement. Also, when using these particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>

    <h2>2. Changes to Terms</h2>
    <p>We reserve the right to modify or replace these Terms at any time. Any changes will be posted on this page, and it's your responsibility to review these Terms periodically for any changes.</p>

    <h2>3. Privacy</h2>
    <p>We value your privacy. The information collected on this platform is governed by our Privacy Policy.</p>

    <h2>4. Use of the User Dashboard</h2>
    <p>You agree not to misuse the User Dashboard and to use it only for lawful purposes related to the services offered by the platform. Any unauthorized use may result in the termination of your access to the platform.</p>

    <h2>5. Limitation of Liability</h2>
    <p>Street Hearts is not responsible for any losses or damages resulting from the use of the User Dashboard. You use this platform at your own risk.</p>

    <h2>6. Contact Us</h2>
    <p>If you have any questions about these Terms, please contact us.</p>
</div>

</body>
</html>
