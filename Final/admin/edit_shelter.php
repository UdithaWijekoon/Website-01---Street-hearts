<?php
include 'db.php'; // Include the database connection
session_start(); // Start the session

// Check if ShelterID is set in the URL
if (isset($_GET['ShelterID'])) {
    $ShelterID = $_GET['ShelterID'];

    // Fetch shelter data from the database
    $stmt = $pdo->prepare("SELECT * FROM shelters WHERE ShelterID = ?");
    $stmt->execute([$ShelterID]);
    $shelter = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ShelterName = $_POST['ShelterName'];
    $Email = $_POST['Email'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Address = $_POST['Address'];
    $DistrictID = $_POST['DistrictID'];

    try {
        // Update shelter details in the database
        $stmt = $pdo->prepare("UPDATE shelters SET ShelterName = ?, Email = ?, PhoneNumber = ?, Address = ?, DistrictID = ? WHERE ShelterID = ?");
        $stmt->execute([$ShelterName, $Email, $PhoneNumber, $Address, $DistrictID, $ShelterID]);

        // Set success message
        $_SESSION['success_message'] = "Shelter details updated successfully!";
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error_message'] = "Error updating shelter details: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shelter</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 600px;
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
        <h1>Edit Shelter</h1>

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
            <label for="ShelterName">Shelter Name</label>
            <input type="text" name="ShelterName" value="<?= $shelter['ShelterName'] ?>" required>

            <label for="Email">Email</label>
            <input type="email" name="Email" value="<?= $shelter['Email'] ?>" required>

            <label for="PhoneNumber">Phone Number</label>
            <input type="text" name="PhoneNumber" value="<?= $shelter['PhoneNumber'] ?>">

            <label for="Address">Address</label>
            <textarea name="Address" required><?= $shelter['Address'] ?></textarea>

            <label for="DistrictID">District</label>
            <input type="text" name="DistrictID" value="<?= $shelter['DistrictID'] ?>" required>

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
