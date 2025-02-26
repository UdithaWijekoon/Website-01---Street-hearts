<?php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

$senderAdminID = $_SESSION['admin_id']; // Assume admin ID is stored in the session
$recipientType = $_POST['recipientType'];
$subject = $_POST['subject'];
$messageContent = $_POST['messageContent'];

// Determine if message is for user or shelter
if ($recipientType == 'user') {
    $receiverUserID = $_POST['userID'];
    $receiverShelterID = NULL;
} elseif ($recipientType == 'shelter') {
    $receiverShelterID = $_POST['shelterID'];
    $receiverUserID = NULL;
}

// Insert message into the messages table
$sql = "INSERT INTO messages (SenderUserID, ReceiverAdminID, ReceiverShelterID, Subject, MessageContent, SentAt) 
        VALUES (:senderAdminID, :receiverUserID, :receiverShelterID, :subject, :messageContent, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':senderAdminID', $senderAdminID);
$stmt->bindParam(':receiverUserID', $receiverUserID);
$stmt->bindParam(':receiverShelterID', $receiverShelterID);
$stmt->bindParam(':subject', $subject);
$stmt->bindParam(':messageContent', $messageContent);
$stmt->execute();

header("Location: admin_messaging_form.php?message=Message sent successfully");
exit();
?>
