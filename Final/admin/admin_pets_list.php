<?php
// admin_pets_list.php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

//header from partials
include('partials/header_admin.php');

try {
    // Fetch all pets
    $stmt = $pdo->query("SELECT * FROM pets");
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pets List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-actions a {
            text-decoration: none;
            color: #28a745;
            margin-right: 10px;
        }

        .table-actions a:hover {
            color: #218838;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-paw"></i> All Pets</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Pet ID</th>
                    <th>Pet Name</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?= htmlspecialchars($pet['PetID']) ?></td>
                        <td><?= htmlspecialchars($pet['PetName']) ?></td>
                        <td><?= htmlspecialchars($pet['Breed']) ?></td>
                        <td><?= htmlspecialchars($pet['Age']) ?></td>
                        <td><?= htmlspecialchars($pet['Gender']) ?></td>
                        <td><?= htmlspecialchars($pet['Status']) ?></td>
                        <td class="table-actions">
                            <a href="edit_pet.php?PetID=<?= $pet['PetID'] ?>"><i class="fas fa-edit"></i> Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
