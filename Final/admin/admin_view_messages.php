<?php
// admin_view_messages.php
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

//header from partials
include('partials/header_admin.php');

// Fetch all messages sent to any admin (since all admins can see all user messages)
$sql = "SELECT m.MessageID, u.Username AS Sender, m.Subject, m.MessageContent, m.SentAt
        FROM messages m
        LEFT JOIN users u ON m.SenderUserID = u.UserID
        WHERE m.ReceiverAdminID IS NOT NULL
        ORDER BY m.SentAt DESC";

$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Messages</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        /* Table Styles */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #4C4D4C;
            color: white;
            font-weight: bold;
        }

        table td {
            background-color: #f9f9f9;
        }

        table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            table th, table td {
                padding: 8px;
            }
        }

        /* Hover Effect */
        table tr:hover td {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<h1><i class="fa fa-comments" aria-hidden="true"></i> Messages from Users</h1>

<table border="1">
    <tr>
        <th>Message ID</th>
        <th>Sender</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Sent At</th>
    </tr>
    <?php foreach ($messages as $message): ?>
        <tr>
            <td><?php echo htmlspecialchars($message['MessageID']); ?></td>
            <td><?php echo htmlspecialchars($message['Sender']); ?></td>
            <td><?php echo htmlspecialchars($message['Subject']); ?></td>
            <td><?php echo htmlspecialchars($message['MessageContent']); ?></td>
            <td><?php echo htmlspecialchars($message['SentAt']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
