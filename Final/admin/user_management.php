<?php
include 'db.php'; // Database connection

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

// Fetch users
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

// Fetch admins
$admins = $pdo->query("SELECT * FROM admins")->fetchAll(PDO::FETCH_ASSOC);

// Fetch shelters
$shelters = $pdo->query("SELECT shelters.*, districts.DistrictName 
                         FROM shelters 
                         JOIN districts ON shelters.DistrictID = districts.DistrictID")->fetchAll(PDO::FETCH_ASSOC);

// Delete functionality for Users, Admins, and Shelters
if (isset($_GET['delete_type']) && isset($_GET['delete_id'])) {
    $type = $_GET['delete_type'];
    $id = $_GET['delete_id'];
    
    try {
        switch ($type) {
            case 'user':
                $stmt = $pdo->prepare("DELETE FROM users WHERE UserID = ?");
                $stmt->execute([$id]);
                $_SESSION['success_message'] = "User deleted successfully!";
                break;
            case 'admin':
                $stmt = $pdo->prepare("DELETE FROM admins WHERE AdminID = ?");
                $stmt->execute([$id]);
                $_SESSION['success_message'] = "Admin deleted successfully!";
                break;
            case 'shelter':
                $stmt = $pdo->prepare("DELETE FROM shelters WHERE ShelterID = ?");
                $stmt->execute([$id]);
                $_SESSION['success_message'] = "Shelter deleted successfully!";
                break;
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // 23000 is the SQLSTATE for foreign key constraint violation
            $_SESSION['error_message'] = "Cannot delete this $type because it is linked to other records.";
        } else {
            $_SESSION['error_message'] = "Error deleting record: " . $e->getMessage();
        }
    }

    header('Location: user_management.php');
    exit();
}
//header from partials
include('partials/header_admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
        background-color: #f8f9fa;  /* Light gray background */
        font-family: Arial, sans-serif;
        padding-top: 20px;
        margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .action-btns {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn2 {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .edit-btn:hover {
            background-color: #08B70F;
        }
        .delete-btn:hover {
            background-color: #CD0000;
        }
        h1{
            text-align: center;
        }
        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            h1 {
                font-size: 24px;
            }

            table, th, td {
                font-size: 14px;
            }

            .btn2 {
                padding: 4px 8px;
                font-size: 12px;
            }

            /* Make the table scrollable */
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        /* Responsive table stacking on smaller screens */
        @media (max-width: 576px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none; /* Hide table headers */
            }

            tr {
                margin-bottom: 10px;
            }

            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }

            td:before {
                content: attr(data-label);
                font-weight: bold;
                flex-basis: 40%;
                text-align: left;
            }

            .action-btns {
                flex-direction: column;
                gap: 5px;
            }
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-users"></i> Manage Users</h1>

        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success">
                <?= htmlspecialchars($_SESSION['success_message']); ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Display error message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="message error">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Users Table -->
        <h2><i class="fas fa-users"></i> Users</h2>
        <table>
            <tr>
                <th>UserID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['UserID'] ?></td>
                <td><?= $user['Username'] ?></td>
                <td><?= $user['Email'] ?></td>
                <td><?= $user['PhoneNumber'] ?></td>
                <td><?= $user['Address'] ?></td>
                <td class="action-btns">
                    <a href="edit_user.php?UserID=<?= $user['UserID'] ?>" class="btn2 edit-btn">Edit</a>
                    <a href="user_management.php?delete_type=user&delete_id=<?= $user['UserID'] ?>" class="btn2 delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Admins Table -->
        <h2><i class="fas fa-user-shield"></i> Admins</h2>
        <table>
            <tr>
                <th>AdminID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?= $admin['AdminID'] ?></td>
                <td><?= $admin['Username'] ?></td>
                <td><?= $admin['Email'] ?></td>
                <td><?= $admin['Role'] ?></td>
                <td class="action-btns">
                    <a href="edit_admin.php?AdminID=<?= $admin['AdminID'] ?>" class="btn2 edit-btn">Edit</a>
                    <a href="user_management.php?delete_type=admin&delete_id=<?= $admin['AdminID'] ?>" class="btn2 delete-btn" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Shelters Table -->
        <h2><i class="fas fa-home"></i> Shelters</h2>
        <table>
            <tr>
                <th>ShelterID</th>
                <th>Shelter Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>District</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($shelters as $shelter): ?>
            <tr>
                <td><?= $shelter['ShelterID'] ?></td>
                <td><?= $shelter['ShelterName'] ?></td>
                <td><?= $shelter['Email'] ?></td>
                <td><?= $shelter['PhoneNumber'] ?></td>
                <td><?= $shelter['DistrictName'] ?></td>
                <td class="action-btns">
                    <a href="edit_shelter.php?ShelterID=<?= $shelter['ShelterID'] ?>" class="btn2 edit-btn">Edit</a>
                    <a href="user_management.php?delete_type=shelter&delete_id=<?= $shelter['ShelterID'] ?>" class="btn2 delete-btn" onclick="return confirm('Are you sure you want to delete this shelter?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html> 
