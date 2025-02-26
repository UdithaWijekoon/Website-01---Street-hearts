<?php
session_start();
session_destroy(); // Destroy all session data

session_start();
$_SESSION['logout_message'] = "You have successfully logged out.";

header("Location: ../login/shelter_login.php"); // Redirect to the login page after logout
exit();
?>
