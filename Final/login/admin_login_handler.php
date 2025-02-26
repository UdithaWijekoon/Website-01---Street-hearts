<?php
session_start();

// Database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch admin details
    $sql = "SELECT AdminID, Password, Role FROM admins WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the admin exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($adminID, $hashed_password, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $adminID;
            $_SESSION['admin_role'] = $role;
            $_SESSION['login_message'] = "Login successful!";
            $_SESSION['login_message_type'] = "success";
            header("Location: ../admin/admin.php");
            exit();
        } else {
            // Invalid password
            header("Location: admin_login.php?error=invalid");
            exit();
        }
    } else {
        // Admin not found
        header("Location: admin_login.php?error=invalid");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>


