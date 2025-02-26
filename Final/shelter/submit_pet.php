<?php
// submit_pet.php

include 'db.php';
session_start();

// Check if the shelter is logged in
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true) {
    header("Location: ../login/shelter_login.php");
    exit();
}

$shelterID = $_SESSION['ShelterID']; // Assume ShelterID is stored in session upon login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petType = $_POST['petType'];
    $petName = $_POST['petName'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $healthStatus = $_POST['healthStatus'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    // Handle file upload
    $profilePicture = $_FILES['profilePicture']['name'];
    $targetDir = "../uploads/pet_profiles/";
    $targetFile = $targetDir . basename($profilePicture);
    move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile);

    try {
        // Insert the new pet into the pending_pets table with petType
        $sql = "INSERT INTO pending_pets (PetType, PetName, Breed, Age, Gender, Size, Color, HealthStatus, Description, Location, Status, ProfilePicture, ShelterID)
                VALUES (:PetType, :PetName, :Breed, :Age, :Gender, :Size, :Color, :HealthStatus, :Description, :Location, :Status, :ProfilePicture, :ShelterID)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'PetType' => $petType,
            'PetName' => $petName,
            'Breed' => $breed,
            'Age' => $age,
            'Gender' => $gender,
            'Size' => $size,
            'Color' => $color,
            'HealthStatus' => $healthStatus,
            'Description' => $description,
            'Location' => $location,
            'Status' => $status,
            'ProfilePicture' => $profilePicture,
            'ShelterID' => $shelterID
        ]);

        // Store success message in session and redirect back to add_pet.php
        $_SESSION['success_message'] = "Pet has been submitted for admin approval successfully!";
        header("Location: add_pet.php");
        exit();
    } catch (PDOException $e) {
        // Store error message in session and redirect back to add_pet.php
        $_SESSION['error_message'] = "Error submitting pet: " . $e->getMessage();
        header("Location: add_pet.php");
        exit();
    }
}
?>
