<?php
// Include database connection
include 'db_connect.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $message_content = $_POST['message_content'];
    $sender_user_id = $_SESSION['UserID']; // Assuming user ID is stored in session
    $receiver_admin_id = 1; // Assuming the message is sent to a primary admin, or you can set dynamically

    // Insert message into the database
    $sql = "INSERT INTO messages (SenderUserID, ReceiverAdminID, Subject, MessageContent) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $sender_user_id, $receiver_admin_id, $subject, $message_content);

    if ($stmt->execute()) {
        // Return a flag for successful submission
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    
    $stmt->close();
    $conn->close();
}
?>
