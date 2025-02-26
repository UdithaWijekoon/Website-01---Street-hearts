<?php
// Include database connection
include 'db_connect.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shelter_id = $_POST['shelter_id'];
    $subject = $_POST['subject'];
    $message_content = $_POST['message_content'];
    $sender_user_id = $_SESSION['UserID']; // Assuming user ID is stored in session

    // Insert message into the database
    $sql = "INSERT INTO messages (SenderUserID, ReceiverShelterID, Subject, MessageContent) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $sender_user_id, $shelter_id, $subject, $message_content);

    if ($stmt->execute()) {
        $status = 'success';
    } else {
        $status = 'error';
        $error_message = $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Status</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Message Submission Status</h1>

    <?php if (isset($status) && $status == 'success'): ?>
        <div class="message success">
            Your message has been successfully sent to the shelter.
        </div>
    <?php elseif (isset($status) && $status == 'error'): ?>
        <div class="message error">
            An error occurred: <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <a href="shelters_and_petcarelocations.php" class="back-button">Back</a>
</div>

</body>
</html>
