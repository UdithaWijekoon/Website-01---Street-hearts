<?php
session_start();
session_destroy(); // Destroy all session data

session_start();
$_SESSION['logout_message'] = "You have successfully logged out.";

header("Location: ../index.php"); // Redirect to the user login page
exit();
?>
