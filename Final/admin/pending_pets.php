<?php
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

try {
    // Fetch all pending pets
    $stmt = $pdo->query("SELECT * FROM pending_pets");
    $pendingPets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching pending pets: " . $e->getMessage();
}

// Get success or error messages from the session
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear the session messages
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

//header from partials
include('partials/header_admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Pets - Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .pet-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            margin: 5px 0;
            color: #666;
        }

        form {
            margin-top: 15px;
        }

        button {
            width: 100px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        button[name="approve"] {
            background-color: #28a745;
            color: white;
            margin-right: 10px;
        }

        button[name="reject"] {
            background-color: #dc3545;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        .pet-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            h3 {
                font-size: 20px;
            }

            button {
                width: 80px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <h2><i class="fas fa-paw"></i> Pending Pets from Shelters</h2>

    <!-- Display success message -->
    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Check if there are no pending pets -->
    <?php if (empty($pendingPets)): ?>
        <div class="alert alert-info">
            No pending pet requests.
        </div>
    <?php else: ?>
        <!-- Display pending pets -->
        <?php foreach ($pendingPets as $pet): ?>
            <div class="pet-card">
                <h3><?php echo htmlspecialchars($pet['PetName']); ?> (<?php echo htmlspecialchars($pet['PetType']); ?>)</h3>
                <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
                <p>Age: <?php echo htmlspecialchars($pet['Age']); ?> years</p>
                <p>Status: <?php echo htmlspecialchars($pet['Status']); ?></p>
                <form action="approve_pet.php" method="POST">
                    <input type="hidden" name="PendingPetID" value="<?php echo $pet['PendingPetID']; ?>">
                    <button type="submit" name="approve">Approve</button>
                    <button type="submit" name="reject">Reject</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
