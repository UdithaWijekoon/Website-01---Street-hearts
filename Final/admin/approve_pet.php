<?php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pendingPetID = $_POST['PendingPetID'];

    try {
        // Fetch the pending pet details based on PendingPetID
        $sql = "SELECT * FROM pending_pets WHERE PendingPetID = :PendingPetID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['PendingPetID' => $pendingPetID]);
        $pendingPet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pendingPet) {
            $_SESSION['error_message'] = "Pet not found in the pending list.";
            header("Location: pending_pets.php");
            exit();
        }

        // If "approve" button is clicked
        if (isset($_POST['approve'])) {
            // Insert the approved pet into the `pets` table
            $sqlInsert = "INSERT INTO pets (PetType, PetName, Breed, Age, Gender, Size, Color, HealthStatus, Description, Location, Status, ProfilePicture, ShelterID)
                          VALUES (:PetType, :PetName, :Breed, :Age, :Gender, :Size, :Color, :HealthStatus, :Description, :Location, :Status, :ProfilePicture, :ShelterID)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                'PetType' => $pendingPet['PetType'],
                'PetName' => $pendingPet['PetName'],
                'Breed' => $pendingPet['Breed'],
                'Age' => $pendingPet['Age'],
                'Gender' => $pendingPet['Gender'],
                'Size' => $pendingPet['Size'],
                'Color' => $pendingPet['Color'],
                'HealthStatus' => $pendingPet['HealthStatus'],
                'Description' => $pendingPet['Description'],
                'Location' => $pendingPet['Location'],
                'Status' => $pendingPet['Status'],
                'ProfilePicture' => $pendingPet['ProfilePicture'],
                'ShelterID' => $pendingPet['ShelterID']
            ]);

            // Delete the pet from the pending_pets table after approval
            $sqlDelete = "DELETE FROM pending_pets WHERE PendingPetID = :PendingPetID";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute(['PendingPetID' => $pendingPetID]);

            // Store success message in session
            $_SESSION['success_message'] = "Pet approved successfully!";
            header("Location: pending_pets.php");
            exit();

        } elseif (isset($_POST['reject'])) {
            // If "reject" button is clicked, just delete the pet from the pending_pets table
            $sqlDelete = "DELETE FROM pending_pets WHERE PendingPetID = :PendingPetID";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute(['PendingPetID' => $pendingPetID]);

            // Store rejection message in session
            $_SESSION['success_message'] = "Pet rejected successfully!";
            header("Location: pending_pets.php");
            exit();
        }

    } catch (PDOException $e) {
        // Store error message in session
        $_SESSION['error_message'] = "Error processing pet approval: " . $e->getMessage();
        header("Location: pending_pets.php");
        exit();
    }
}
?>
