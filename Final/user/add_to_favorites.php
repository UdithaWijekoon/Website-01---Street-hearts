<?php

include 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

$userID = $_SESSION['UserID'];
$petID = $_POST['PetID'] ?? null;

$message = '';
$messageType = '';

if ($petID) {
    try {
        // Check if the pet is already saved
        $stmt = $pdo->prepare("SELECT * FROM saved_pets WHERE UserID = :UserID AND PetID = :PetID");
        $stmt->execute(['UserID' => $userID, 'PetID' => $petID]);
        $savedPet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$savedPet) {
            // Insert the new saved pet record
            $insertStmt = $pdo->prepare("INSERT INTO saved_pets (UserID, PetID) VALUES (:UserID, :PetID)");
            $insertStmt->execute(['UserID' => $userID, 'PetID' => $petID]);

            $message = "Pet added to favorites successfully!";
            $messageType = 'success';
        } else {
            $message = "This pet is already in your favorites.";
            $messageType = 'error';
        }
    } catch (PDOException $e) {
        $message = "Error updating favorites: " . $e->getMessage();
        $messageType = 'error';
    }
} else {
    $message = "No pet selected.";
    $messageType = 'error';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites Status</title>
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
    <h1>Favorites Status</h1>

    <?php if ($message): ?>
        <div class="message <?php echo htmlspecialchars($messageType); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <button class="back-button" onclick="goBack()">Back</button>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
