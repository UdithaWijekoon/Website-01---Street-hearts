<?php
// admin_adoption_history.php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

//header from partials
include('partials/header_admin.php');
try {
    // Fetch adoption history
    $sql = "SELECT aa.ApplicationID, aa.ApplicationDate, p.PetName, p.Breed, u.UserName, s.ShelterName
            FROM adoption_applications aa
            JOIN pets p ON aa.PetID = p.PetID
            JOIN users u ON aa.UserID = u.UserID
            JOIN shelters s ON p.ShelterID = s.ShelterID
            WHERE aa.Status = 'Approved'";
    $stmt = $pdo->query($sql);
    $adoption_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            color: #333;
        }

        th {
            background-color: #4C4D4C;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #999;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            table, th, td {
                font-size: 14px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<div class="container">
        <h1><i class="fa fa-history" aria-hidden="true"></i> Adoption History</h1>
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Application Date</th>
                    <th>Pet Name</th>
                    <th>Breed</th>
                    <th>Adopter</th>
                    <th>Shelter</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($adoption_history)): ?>
                    <?php foreach ($adoption_history as $history): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($history['ApplicationID']); ?></td>
                            <td><?php echo htmlspecialchars($history['ApplicationDate']); ?></td>
                            <td><?php echo htmlspecialchars($history['PetName']); ?></td>
                            <td><?php echo htmlspecialchars($history['Breed']); ?></td>
                            <td><?php echo htmlspecialchars($history['UserName']); ?></td>
                            <td><?php echo htmlspecialchars($history['ShelterName']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">No adoptions have been approved yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
