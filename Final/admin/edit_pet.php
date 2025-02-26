<?php
// edit_pet.php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

$petID = $_GET['PetID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for editing pet
    $petName = $_POST['PetName'];
    $breed = $_POST['Breed'];
    $age = $_POST['Age'];
    $gender = $_POST['Gender'];
    $status = $_POST['Status'];

    try {
        $stmt = $pdo->prepare("UPDATE pets SET PetName = :PetName, Breed = :Breed, Age = :Age, Gender = :Gender, Status = :Status WHERE PetID = :PetID");
        $stmt->execute(['PetName' => $petName, 'Breed' => $breed, 'Age' => $age, 'Gender' => $gender, 'Status' => $status, 'PetID' => $petID]);
        
        // Store success message in session
        $_SESSION['success_message'] = "Pet updated successfully!";
        header("Location: edit_pet.php?PetID=$petID");
        exit();
    } catch (PDOException $e) {
        // Store error message in session
        $_SESSION['error_message'] = "Error updating pet: " . $e->getMessage();
        header("Location: edit_pet.php?PetID=$petID");
        exit();
    }
} else {
    // Fetch the current pet details
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE PetID = :PetID");
    $stmt->execute(['PetID' => $petID]);
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"],
        .back-btn {
            width: 100%;
            padding: 10px 0px 10px 0px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .back-btn {
            background-color: #007bff;
        }

        button[type="submit"]:hover,
        .back-btn:hover {
            opacity: 0.9;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            form {
                padding: 15px;
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
    <h1>Edit Pet</h1>
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

    <form method="POST">
        <label for="PetName">Pet Name:</label>
        <input type="text" name="PetName" value="<?= htmlspecialchars($pet['PetName']) ?>" required>

        <label for="Breed">Breed:</label>
        <input type="text" name="Breed" value="<?= htmlspecialchars($pet['Breed']) ?>">

        <label for="Age">Age:</label>
        <input type="number" name="Age" value="<?= htmlspecialchars($pet['Age']) ?>" required>

        <label for="Gender">Gender:</label>
        <select name="Gender">
            <option value="Male" <?= $pet['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $pet['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>

        <label for="Status">Status:</label>
        <select name="Status">
            <option value="Available" <?= $pet['Status'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Adopted" <?= $pet['Status'] == 'Adopted' ? 'selected' : '' ?>>Adopted</option>
        </select>

        <button type="submit">Update Pet</button>
        <!-- Back button as a link -->
        <a href="admin_pets_list.php" class="back-btn">←Back</a>
    </form>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
