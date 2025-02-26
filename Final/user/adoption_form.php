<?php
// adoption_form.php

include 'db.php';

session_start();

// Fetch UserID from the session
$userID = $_SESSION['UserID'] ?? null; // Fetch UserID from session, or set to null if not available

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !$userID) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch PetID from the URL
$petID = $_GET['PetID'] ?? null;

// Fetch pet details if PetID is provided
if ($petID) {
    try {
        // Fetch pet details
        $stmtPet = $pdo->prepare("SELECT PetName FROM pets WHERE PetID = :PetID");
        $stmtPet->execute(['PetID' => $petID]);
        $pet = $stmtPet->fetch(PDO::FETCH_ASSOC);

        // Fetch user details using UserID from session
        $stmtUser = $pdo->prepare("SELECT Username FROM users WHERE UserID = :UserID");
        $stmtUser->execute(['UserID' => $userID]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if (!$pet || !$user) {
            echo "Invalid pet or user information.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching details: " . $e->getMessage();
        exit;
    }
} else {
    echo "Pet information missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application Form</title>
    <link rel="stylesheet" href="css/style.css">
    <style>

        body {
            background-color: var(--primary-clr);
        }

        .form-container {
            background-color: var(--purple-white);
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: 40px auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .check-form-group {
            display: flex;
        }

        .submit-btn {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
</head>
<body>

<div class="form-container">
    <h2>Adoption Application Form</h2>
    <form action="submit_adoption_application.php" method="POST">
        <div class="form-group">
            <label for="petName">Pet Name:</label>
            <input type="text" id="petName" name="petName" value="<?php echo htmlspecialchars($pet['PetName']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="reason">Reason for Adoption:</label>
            <textarea id="reason" name="reason" required></textarea>
        </div>

        <div class="form-group">
            <label for="previousExperience">Previous Pet Ownership Experience:</label>
            <select id="previousExperience" name="previousExperience" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="homeEnvironment">Home Environment Description:</label>
            <textarea id="homeEnvironment" name="homeEnvironment" required></textarea>
        </div>

        <div class="form-group">
            <label for="contactInfo">Contact Information:</label>
            <input type="text" id="contactInfo" name="contactInfo" required>
        </div>

        <div class="check-form-group">
            <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
            <label for="agreeTerms">I agree to the Adoption Terms and Conditions</label>
        </div>

        <input type="hidden" name="PetID" value="<?php echo $petID; ?>">
        <input type="hidden" name="UserID" value="<?php echo $userID; ?>">

        <button type="submit" class="submit-btn btn primary-btn">Submit Application</button>
        <a href="javascript:history.back()" class="btn secondary-btn">Go Back</a>
    </form>
</div>

</body>
</html>
