<?php 
include 'db.php';

session_start();

// Check if the shelter is logged in
$shelterID = $_SESSION['ShelterID'] ?? null;
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true || !$shelterID) {
    header("Location: ../login/shelter_login.php");
    exit();
}
include('partials/header_shelter.php');

// Fetch pet-adding history for the logged-in shelter from the 'pets' table
try {
    $stmt = $pdo->prepare("SELECT PetName, Breed, Age, Gender, Size, Color, HealthStatus, Status, CreatedAt
                           FROM pets
                           WHERE ShelterID = :shelterID
                           ORDER BY CreatedAt DESC");
    $stmt->execute(['shelterID' => $shelterID]);
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching pet history: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adding History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f8f9fa;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        @media (max-width: 768px) {
    table th, table td {
        font-size: 0.9rem;
        padding: 8px;
    }

    h2 {
        font-size: 1.8rem;
    }

    table {
        font-size: 0.9rem;
    }

    .container {
        margin-top: 30px;
    }
}

@media (max-width: 576px) {
    table th, table td {
        font-size: 0.8rem;
        padding: 6px;
    }

    h2 {
        font-size: 1.5rem;
    }

    .container {
        margin-top: 20px;
    }

    table {
        font-size: 0.8rem;
    }

    table th, table td {
        display: block;
        width: 100%;
        text-align: left;
    }

    table thead {
        display: none;
    }

    table tbody tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
    }

    table td {
        border: none;
        border-bottom: 1px solid #ddd;
        padding-left: 50%;
        position: relative;
    }

    table td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
    }

    .alert {
        font-size: 0.9rem;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-history"></i> Pet Adding History</h2>

    <?php if (count($pets) > 0): ?>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th><i class="fas fa-paw"></i> Pet Name</th>
                    <th><i class="fas fa-dna"></i> Breed</th>
                    <th><i class="fas fa-birthday-cake"></i> Age</th>
                    <th><i class="fas fa-venus-mars"></i> Gender</th>
                    <th><i class="fas fa-ruler"></i> Size</th>
                    <th><i class="fas fa-palette"></i> Color</th>
                    <th><i class="fas fa-heartbeat"></i> Health Status</th>
                    <th><i class="fas fa-check-circle"></i> Status</th>
                    <th><i class="fas fa-calendar-alt"></i> Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet['PetName']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Breed']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Age']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Gender']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Size']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Color']); ?></td>
                        <td><?php echo htmlspecialchars($pet['HealthStatus']); ?></td>
                        <td><?php echo htmlspecialchars($pet['Status']); ?></td>
                        <td><?php echo htmlspecialchars($pet['CreatedAt']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-warning text-center"><i class="fas fa-exclamation-circle"></i> No pets have been added by this shelter.</p>
    <?php endif; ?>
</div>

<!-- footer from partials -->
<?php include('partials/footer_shelter.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
