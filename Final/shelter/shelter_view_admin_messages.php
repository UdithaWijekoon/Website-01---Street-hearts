<?php 
include 'db.php';
session_start();

// Check if the shelter is logged in
$shelterID = $_SESSION['ShelterID'] ?? null;
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true || !$shelterID) {
    header("Location: ../login/shelter_login.php");
    exit();
}
include('partials/header_shelter.php');

// Debugging: Check if shelterID is correctly set
if (!$shelterID) {
    echo "Shelter ID is not set in the session. Check login process.";
    exit();
}

$sql = "SELECT * FROM admin_messages 
        WHERE ReceiverShelterID = :receiver_shelter_id 
        ORDER BY SentAt DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['receiver_shelter_id' => $shelterID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Messages from Admins</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }
        .container {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            color: white;
            text-align: left;
            padding: 10px;
            color: #333;
        }
        table td {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        table tr:hover {
            background-color: #e9ecef;
        }
        .no-messages {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #dc3545;
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
    <h2><i class="fa fa-comments" aria-hidden="true"></i> Messages from Admins</h2>

    <?php if ($messages): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['Subject']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['MessageContent'])); ?></td>
                        <td><?php echo $message['SentAt']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-messages"> No messages from admins yet.</p>
    <?php endif; ?>
</div>

<!-- footer from partials -->
<?php include('partials/footer_shelter.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
