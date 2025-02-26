<?php
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php"); 
    exit();
}

//header from partials
include('partials/header_admin.php');

$sql = "SELECT f.Rating, f.Comments, f.FeedbackDate, u.Username FROM feedback f JOIN users u ON f.UserID = u.UserID ORDER BY f.FeedbackDate DESC";
$stmt = $pdo->query($sql);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .feedback-container {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .feedback-container p {
            margin: 5px 0;
        }

        .feedback-container strong {
            color: #007bff;
        }

        hr {
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        .no-feedback {
            text-align: center;
            color: #666;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .feedback-container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <h1><i class="fa fa-commenting" aria-hidden="true"></i> User Feedback</h1>
    <?php if (!empty($feedbacks)): ?>
        <?php foreach ($feedbacks as $feedback): ?>
            <div class="feedback-container">
                <p><strong><?php echo htmlspecialchars($feedback['Username']); ?></strong> rated <strong><?php echo htmlspecialchars($feedback['Rating']); ?>/5</strong></p>
                <p>Comments: <?php echo htmlspecialchars($feedback['Comments']); ?></p>
                <p>Date: <?php echo htmlspecialchars($feedback['FeedbackDate']); ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-feedback">No feedback yet.</p>
    <?php endif; ?>
    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
