<?php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $volunteerID = $_POST['VolunteerID'];
    $action = $_POST['action'];

    $status = ($action == 'approve') ? 'Approved' : 'Rejected';

    try {
        $sql = "UPDATE volunteers SET ApplicationStatus = :status WHERE VolunteerID = :volunteerID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':volunteerID' => $volunteerID
        ]);

        // Set success message
        $_SESSION['message'] = "Volunteer application has been " . ($action == 'approve' ? "approved." : "rejected.");

    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    // Redirect back to the volunteer requests page
    header("Location: view_volunteer_requests.php");
    exit();
}
?>
