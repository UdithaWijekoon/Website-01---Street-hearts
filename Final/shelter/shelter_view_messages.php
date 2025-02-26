<!-- header from partials -->
<?php 
include 'db.php';

session_start();

// Check if the shelter is logged in
$shelterID = $_SESSION['ShelterID'] ?? null;
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true || !$shelterID) {
    header("Location: ../login/shelter_login.php");
    exit();
}

// Fetch messages for the logged-in shelter
try {
    $stmt = $pdo->prepare("SELECT m.MessageID, m.Subject, m.MessageContent, m.SentAt, u.Username AS SenderName
                           FROM messages m
                           LEFT JOIN users u ON m.SenderUserID = u.UserID
                           WHERE m.ReceiverShelterID = :shelterID
                           ORDER BY m.SentAt DESC");
    $stmt->execute(['shelterID' => $shelterID]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching messages: " . $e->getMessage();
    exit();
}
include('partials/header_shelter.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Messages</title>
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th { 
            background-color: #fff;
            color: #333; 
        }
        table td {
            background-color: #f8f9fa;
        }
        table tr:hover {
            background-color: #e9ecef;
        }
        .a2 {
            color: #007bff;
            text-decoration: none;
        }
        .a2:hover {
            text-decoration: underline;
        }
        .no-messages {
            text-align: center;
            color: #dc3545;
            font-size: 18px;
        }
        @media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h2 {
        font-size: 24px;
    }

    table, th, td {
        font-size: 14px;
        padding: 8px;
    }

    .no-messages {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    table, th, td {
        display: block;
        width: 100%;
        text-align: left;
    }

    table thead {
        display: none;
    }

    table tbody tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
    }

    table td {
        border: none;
        border-bottom: 1px solid #ddd;
        padding-left: 50%;
        position: relative;
    }

    table td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
    }

    h2 {
        font-size: 20px;
    }

    .no-messages {
        font-size: 14px;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa fa-comments" aria-hidden="true"></i> Messages from Users</h2>
    
    <?php if (count($messages) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Sender</th>
                    <th>Date Sent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['Subject']); ?></td>
                        <td><?php echo htmlspecialchars($message['SenderName'] ?? 'Unknown'); ?></td>
                        <td><?php echo htmlspecialchars($message['SentAt']); ?></td>
                        <td><a class="a2" href="view_message.php?MessageID=<?php echo $message['MessageID']; ?>">View Message</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-messages"><i class="fas fa-exclamation-circle"></i> No messages found.</p>
    <?php endif; ?>

</div>
<!-- footer from partials -->
<?php include('partials/footer_shelter.php'); ?>
</body>
</html>
