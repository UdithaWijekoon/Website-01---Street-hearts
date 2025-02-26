<!-- process_application.php -->
<?php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the Application ID and action from the URL
$applicationID = $_GET['ApplicationID'];
$action = $_GET['action'];

try {
    // Fetch the application to get the PetID
    $sql = "SELECT PetID FROM adoption_applications WHERE ApplicationID = :applicationID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['applicationID' => $applicationID]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($application) {
        $petID = $application['PetID'];

        // Process the action (approve or decline)
        if ($action === 'approve') {
            // Update the application's status to 'Approved'
            $sql = "UPDATE adoption_applications SET Status = 'Approved' WHERE ApplicationID = :applicationID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['applicationID' => $applicationID]);

            // Update the pet's status to 'Adopted'
            $sql = "UPDATE pets SET Status = 'Adopted' WHERE PetID = :petID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['petID' => $petID]);

            $_SESSION['message'] = "Application approved and pet status updated to 'Adopted'.";
        } elseif ($action === 'decline') {
            // Update the application's status to 'Rejected'
            $sql = "UPDATE adoption_applications SET Status = 'Rejected' WHERE ApplicationID = :applicationID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['applicationID' => $applicationID]);

            $_SESSION['message'] = "Application rejected.";
        }

        // Redirect back to the admin review page
        header("Location: admin_review_adoptions.php");
        exit();
    } else {
        echo "Application not found.";
    }
} catch (PDOException $e) {
    echo "Error processing application: " . $e->getMessage();
}
?>
