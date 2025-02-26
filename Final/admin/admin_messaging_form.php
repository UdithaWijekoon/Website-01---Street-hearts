<?php
// admin_send_message.php

include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

//header from partials
include('partials/header_admin.php');

// Fetch users and shelters for message selection
$sqlUsers = "SELECT UserID, Username FROM users";
$stmtUsers = $pdo->prepare($sqlUsers);
$stmtUsers->execute();
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

$sqlShelters = "SELECT ShelterID, ShelterName FROM shelters";
$stmtShelters = $pdo->prepare($sqlShelters);
$stmtShelters->execute();
$shelters = $stmtShelters->fetchAll(PDO::FETCH_ASSOC);

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $messageContent = $_POST['messageContent'];

    // Check if the form is targeting a user or a shelter
    $receiverUserID = isset($_POST['receiver_user_id']) && !empty($_POST['receiver_user_id']) ? $_POST['receiver_user_id'] : null;
    $receiverShelterID = isset($_POST['receiver_shelter_id']) && !empty($_POST['receiver_shelter_id']) ? $_POST['receiver_shelter_id'] : null;

    // Determine if we are sending to a user or shelter
    if ($receiverUserID) {
        // Insert message for the user
        $sql = "INSERT INTO admin_messages (SenderAdminID, ReceiverUserID, Subject, MessageContent) 
                VALUES (:sender_admin_id, :receiver_user_id, :subject, :message_content)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'sender_admin_id' => $_SESSION['admin_id'], // Assuming admin ID is stored in session
            'receiver_user_id' => $receiverUserID,
            'subject' => $subject,
            'message_content' => $messageContent
        ]);
        echo '<div class="message success">Message successfully sent to user!</div>';
    } elseif ($receiverShelterID) {
        // Insert message for the shelter
        $sql = "INSERT INTO admin_messages (SenderAdminID, ReceiverShelterID, Subject, MessageContent) 
                VALUES (:sender_admin_id, :receiver_shelter_id, :subject, :message_content)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'sender_admin_id' => $_SESSION['admin_id'], // Assuming admin ID is stored in session
            'receiver_shelter_id' => $receiverShelterID,
            'subject' => $subject,
            'message_content' => $messageContent
        ]);
        echo '<div class="message success">Message successfully sent to shelter!</div>';
    } else {
        echo '<div class="message error">Please select either a user or a shelter to send the message.</div>';
    }
}
$adminID = $_SESSION['admin_id']; // Assuming admin ID is stored in session

// Fetch messages sent by the logged-in admin
$sqlMessages = "SELECT m.MessageID, m.Subject, m.MessageContent, m.SentAt, 
                       u.Username AS ReceiverUsername, s.ShelterName AS ReceiverShelterName
                FROM admin_messages m
                LEFT JOIN users u ON m.ReceiverUserID = u.UserID
                LEFT JOIN shelters s ON m.ReceiverShelterID = s.ShelterID
                WHERE m.SenderAdminID = :adminID";
$stmtMessages = $pdo->prepare($sqlMessages);
$stmtMessages->execute([':adminID' => $adminID]);
$messages = $stmtMessages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .form2 {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn2[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn2[type="submit"]:hover {
            background-color: #218838;
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
        }

        table td {
            background-color: #f9f9f9;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
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
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 15px;
            }

            table {
                width: 100%;
            }

            table th, table td {
                font-size: 14px;
            }

            button[type="submit"] {
                font-size: 14px;
            }
        }

        /* Hover Effects */
        table tr:hover {
            background-color: #f1f1f1;
        }

        input, select, textarea {
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
            outline: none;
        }
    </style>
</head>
<body>

<h1><i class="fa fa-comments" aria-hidden="true"></i> Send a Message</h1>

<form class="form2" action="admin_messaging_form.php" method="POST">
    <label for="subject">Subject:</label><br>
    <input type="text" id="subject" name="subject" required><br><br>

    <label for="messageContent">Message:</label><br>
    <textarea id="messageContent" name="messageContent" rows="5" required></textarea><br><br>

    <!-- Send to User -->
    <label for="receiver_user_id">Send to User:</label>
    <select id="receiver_user_id" name="receiver_user_id" onchange="toggleSelects('user')">
        <option value="">Select a User (optional)</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['UserID'] ?>"><?= $user['Username'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- Send to Shelter -->
    <label for="receiver_shelter_id">Send to Shelter:</label>
    <select id="receiver_shelter_id" name="receiver_shelter_id" onchange="toggleSelects('shelter')">
        <option value="">Select a Shelter (optional)</option>
        <?php foreach ($shelters as $shelter): ?>
            <option value="<?= $shelter['ShelterID'] ?>"><?= $shelter['ShelterName'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button class="btn2" type="submit">Send Message</button>
</form>

<h1>Sent Messages</h1>

<table border="1">
    <tr>
        <th>Subject</th>
        <th>Message</th>
        <th>Receiver (User or Shelter)</th>
        <th>Sent At</th>
    </tr>
    <?php foreach ($messages as $message): ?>
    <tr>
        <td><?= htmlspecialchars($message['Subject']) ?></td>
        <td><?= htmlspecialchars($message['MessageContent']) ?></td>
        <td>
            <?php
            if ($message['ReceiverUsername']) {
                echo "User: " . htmlspecialchars($message['ReceiverUsername']);
            } elseif ($message['ReceiverShelterName']) {
                echo "Shelter: " . htmlspecialchars($message['ReceiverShelterName']);
            } else {
                echo "Unknown";
            }
            ?>
        </td>
        <td><?= htmlspecialchars($message['SentAt']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
// Function to toggle between user and shelter dropdowns
function toggleSelects(selected) {
    var userSelect = document.getElementById('receiver_user_id');
    var shelterSelect = document.getElementById('receiver_shelter_id');

    if (selected === 'user') {
        // If user is selected, disable the shelter dropdown
        if (userSelect.value !== "") {
            shelterSelect.disabled = true;
        } else {
            shelterSelect.disabled = false;
        }
    } else if (selected === 'shelter') {
        // If shelter is selected, disable the user dropdown
        if (shelterSelect.value !== "") {
            userSelect.disabled = true;
        } else {
            userSelect.disabled = false;
        }
    }
}
</script>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
