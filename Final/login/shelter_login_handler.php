<?php
include 'db.php'; 

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to get shelter details
    $stmt = $pdo->prepare("SELECT ShelterID, Password FROM shelters WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $shelter = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($shelter && password_verify($password, $shelter['Password'])) {
        // Set session variables for the shelter
        $_SESSION['shelter_logged_in'] = true;
        $_SESSION['ShelterID'] = $shelter['ShelterID']; // Store ShelterID in the session
        $_SESSION['login_message'] = "Login successful!";
        $_SESSION['login_message_type'] = "success";

        header("Location: ../shelter/shelter.php"); // Redirect to shelter dashboard
        exit();
    } else {
        // Invalid password
        header("Location: shelter_login.php?error=invalid");
        exit();
    }
}
?>
