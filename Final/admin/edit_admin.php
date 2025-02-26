<?php
include 'db.php'; // Include the database connection
session_start(); // Start the session to store messages

// Check if AdminID is set in the URL
if (isset($_GET['AdminID'])) {
    $AdminID = $_GET['AdminID'];

    // Fetch admin data from the database
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE AdminID = ?");
    $stmt->execute([$AdminID]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Role = $_POST['Role'];

    try {
        // Update admin details in the database
        $stmt = $pdo->prepare("UPDATE admins SET Username = ?, Email = ?, Role = ? WHERE AdminID = ?");
        $stmt->execute([$Username, $Email, $Role, $AdminID]);

        // Store success message
        $_SESSION['success_message'] = "Admin details updated successfully!";
    } catch (PDOException $e) {
        // Store error message
        $_SESSION['error_message'] = "Error updating admin details: " . $e->getMessage();
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        /* Responsive design */
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
        <h1>Edit Admin</h1>

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
            <input type="text" name="Username" value="<?= $admin['Username'] ?>" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" value="<?= $admin['Email'] ?>" required>

            <label for="Role">Role</label>
            <input type="text" name="Role" value="<?= $admin['Role'] ?>" required>

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
