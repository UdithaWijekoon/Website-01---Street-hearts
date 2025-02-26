<?php
include 'db.php'; // Include the database connection
session_start(); // Start the session

if (isset($_GET['UserID'])) {
    $UserID = $_GET['UserID'];
    
    // Fetch user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->execute([$UserID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Address = $_POST['Address'];

    try {
        // Update user details
        $stmt = $pdo->prepare("UPDATE users SET Username = ?, Email = ?, PhoneNumber = ?, Address = ? WHERE UserID = ?");
        $stmt->execute([$Username, $Email, $PhoneNumber, $Address, $UserID]);

        // Set success message
        $_SESSION['success_message'] = "User details updated successfully!";
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error_message'] = "Error updating user details: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #555;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
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
    </style>
</head>
<body>
<div class="container">
        <h1>Edit User</h1>

        <!-- Display success message -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message success">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
        </div>
        <?php unset($_SESSION['success_message']); // Clear message after displaying ?>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="message error">
            <?= htmlspecialchars($_SESSION['error_message']); ?>
        </div>
        <?php unset($_SESSION['error_message']); // Clear message after displaying ?>
    <?php endif; ?>
    
        <form method="POST" action="">
            <label for="Username">Username</label>
            <input type="text" name="Username" value="<?= $user['Username'] ?>" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" value="<?= $user['Email'] ?>" required>

            <label for="PhoneNumber">Phone Number</label>
            <input type="text" name="PhoneNumber" value="<?= $user['PhoneNumber'] ?>">

            <label for="Address">Address</label>
            <textarea name="Address" required><?= $user['Address'] ?></textarea>

            <button type="submit">Save Changes</button>
        </form>

        <div class="back-link">
            <a href="user_management.php">← Back</a>
        </div>
    </div>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
