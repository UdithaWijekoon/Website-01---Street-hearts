<?php
// submit_adoption_application.php

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $petID = $_POST['PetID'] ?? null;
    $userID = $_POST['UserID'] ?? null;
    $reasonForAdoption = $_POST['reason'] ?? null;
    $previousPetOwnership = ($_POST['previousExperience'] === 'Yes') ? 1 : 0;
    $homeEnvironment = $_POST['homeEnvironment'] ?? null;
    $contactInformation = $_POST['contactInfo'] ?? null;
    $agreeToTerms = isset($_POST['agreeTerms']) ? 1 : 0;

    // Validate required fields
    if (empty($petID) || empty($userID) || empty($reasonForAdoption) || empty($homeEnvironment) || empty($contactInformation) || !$agreeToTerms) {
        $message = "Please fill all required fields and agree to the terms.";
        $status = "error";
    } else {
        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO adoption_applications 
                    (PetID, UserID, ReasonForAdoption, PreviousPetOwnershipExperience, HomeEnvironmentDescription, ContactInformation, AgreeToTerms) 
                    VALUES 
                    (:petID, :userID, :reasonForAdoption, :previousPetOwnership, :homeEnvironment, :contactInformation, :agreeToTerms)";

            $stmt = $pdo->prepare($sql);

            // Bind parameters and execute the statement
            $stmt->execute([
                ':petID' => $petID,
                ':userID' => $userID,
                ':reasonForAdoption' => $reasonForAdoption,
                ':previousPetOwnership' => $previousPetOwnership,
                ':homeEnvironment' => $homeEnvironment,
                ':contactInformation' => $contactInformation,
                ':agreeToTerms' => $agreeToTerms,
            ]);

            $message = "Your adoption application has been submitted successfully!";
            $status = "success";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $status = "error";
        }
    }
} else {
    $message = "Invalid request method.";
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 18px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="message <?php echo $status; ?>">
    <?php echo $message; ?>
</div>

<a href="javascript:void(0);" onclick="goBack()" class="back-button">Back</a>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
