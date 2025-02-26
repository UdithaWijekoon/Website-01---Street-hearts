<?php
// submit_feedback.php

include 'db.php';

session_start();

// Fetch UserID from the session
$userID = $_SESSION['UserID'] ?? null;

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !$userID) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $rating = $_POST['rating'] ?? null;
    $comments = $_POST['comments'] ?? null;

    // Validate input
    if (empty($rating) || empty($comments)) {
        echo "Please provide both rating and comments.";
        exit;
    }

    // Validate rating (should be between 1 and 5)
    if ($rating < 1 || $rating > 5) {
        echo "Invalid rating. Please provide a rating between 1 and 5.";
        exit;
    }

    // Insert the feedback into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO feedback (UserID, Rating, Comments, FeedbackDate) VALUES (:UserID, :Rating, :Comments, NOW())");
        $stmt->execute([
            'UserID' => $userID,
            'Rating' => $rating,
            'Comments' => $comments
        ]);

        // Redirect back to the feedback form with success message
        header("Location: feedback.php?status=success&message=Thank%20you%20for%20your%20feedback!");
        exit();
    } catch (PDOException $e) {
        header("Location: feedback.php?status=error&message=Error%20submitting%20feedback:%20" . urlencode($e->getMessage()));
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
