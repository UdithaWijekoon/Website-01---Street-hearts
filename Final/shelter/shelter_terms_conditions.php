<?php 
session_start();

// Check if the shelter is logged in
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true) {
    header("Location: ../login/shelter_login.php");
    exit();
}
include('partials/header_shelter.php');

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Terms and Conditions</title>
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #892727;
            margin-top: 30px;
        }

        p {
            line-height: 1.8;
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1><i class="fa fa-check-circle" aria-hidden="true"></i> Shelter Terms and Conditions</h1>
    <h4>Welcome to the Shelter Dashboard of Street Hearts. Please read these Terms and Conditions carefully before using the website or its services.</h4>

    <h2>1. Acceptance of Terms</h2>
    <p>By accessing and using this platform, you accept and agree to be bound by the terms and provisions of this agreement. Also, when using these particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>

    <h2>2. Changes to Terms</h2>
    <p>We reserve the right to modify or replace these Terms at any time. Any changes will be posted on this page, and it's your responsibility to review these Terms periodically for any changes.</p>

    <h2>3. Privacy</h2>
    <p>We value your privacy. The information collected on this platform is governed by our Privacy Policy.</p>

    <h2>4. Use of the Shelter Dashboard</h2>
    <p>You agree not to misuse the Shelter Dashboard and to use it only for lawful purposes related to the management and maintenance of the platform and shelter operations. Any unauthorized use may result in the termination of your access to the platform.</p>

    <h2>5. Limitation of Liability</h2>
    <p>Street Hearts is not responsible for any losses or damages resulting from the use of the Shelter Dashboard. You use this platform at your own risk.</p>

    <h2>6. Contact Us</h2>
    <p>If you have any questions about these Terms, please contact us at admin_streethearts@gmail.com</p>
</div>

<!-- footer from partials -->
<div class="footer">
    <?php include('partials/footer_shelter.php'); ?>
</div>

</body>
</html>
