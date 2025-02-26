<?php
include 'db.php';

session_start();

// Check if the shelter is logged in
$shelterID = $_SESSION['ShelterID'] ?? null;
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true || !$shelterID) {
    header("Location: ../login/shelter_login.php");
    exit();
}

// Fetch the message details
$messageID = $_GET['MessageID'] ?? null;

if ($messageID) {
    try {
        $stmt = $pdo->prepare("SELECT m.Subject, m.MessageContent, m.SentAt, u.Username AS SenderName
                               FROM messages m
                               LEFT JOIN users u ON m.SenderUserID = u.UserID
                               WHERE m.MessageID = :messageID AND m.ReceiverShelterID = :shelterID");
        $stmt->execute(['messageID' => $messageID, 'shelterID' => $shelterID]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$message) {
            echo "Message not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error fetching message details: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid message ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .message-info {
            margin-bottom: 20px;
        }
        .message-info strong {
            display: inline-block;
            width: 100px;
        }
        .message-content {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        a{
            text-decoration: none;
            color: #0C4997;
        }
        a:hover{
            text-decoration: underline;
            color: #0A3266;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Message Details</h2>
    
    <div class="message-info">
        <p><strong>Subject:</strong> <?php echo htmlspecialchars($message['Subject']); ?></p>
        <p><strong>Sender:</strong> <?php echo htmlspecialchars($message['SenderName'] ?? 'Unknown'); ?></p>
        <p><strong>Sent At:</strong> <?php echo htmlspecialchars($message['SentAt']); ?></p>
    </div>
    
    <div class="message-content">
        <p><?php echo nl2br(htmlspecialchars($message['MessageContent'])); ?></p>
    </div>

    <a href="shelter_view_messages.php">←Back to Messages</a>

</div>

</body>
</html>
