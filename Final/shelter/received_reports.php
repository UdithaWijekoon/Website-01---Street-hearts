<?php 
include 'db.php';

session_start();

// Check if the shelter is logged in
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true) {
    header("Location: ../login/shelter_login.php"); // Redirect to login page if not logged in
    exit();
}
include('partials/header_shelter.php');

// Get the shelter ID from the session (assuming it's stored when the shelter logs in)
$shelterID = $_SESSION['ShelterID'];

// Fetch approved reports assigned to the logged-in shelter
$sql = "SELECT * FROM report WHERE shelter_id = :shelter_id AND approval_status = 'approved'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['shelter_id' => $shelterID]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Dashboard - Assigned Reports</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }
        .container {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background-color: #17a2b8;
            color: white;
            text-align: left;
            padding: 10px;
            color: black;
        }
        table td {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        table td img {
            border-radius: 5px;
        }
        table tr:hover {
            background-color: #e9ecef;
        }
        .no-reports {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #dc3545;
        }
        .btn-info{
            background-color: #19B340;
            border: none;
        }
        .btn-info:hover{
            background-color: #42FF39;
            border: none;
        }
        @media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h2 {
        font-size: 24px;
    }

    table, th, td {
        font-size: 14px;
        padding: 8px;
    }

    table td img {
        width: 80px;
    }

    .btn {
        padding: 6px 12px;
        font-size: 14px;
    }

    .no-reports {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    table, th, td {
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

    table td img {
        display: block;
        margin-bottom: 10px;
    }

    .btn {
        display: block;
        width: 100%;
    }

    h2 {
        font-size: 20px;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa fa-flag" aria-hidden="true"></i> Received Reports</h2>

    <?php if (!empty($reports)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Location</th>
                    <th>Live Location Link</th>
                    <th>Date Reported</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['report_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['pet_description']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($report['photo_url']); ?>" alt="Pet Photo" width="100"></td>
                        <td><?php echo htmlspecialchars($report['location_description']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($report['live_location_link']); ?>" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-map-marker-alt"></i> View Location</a></td>
                        <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-reports"><i class="fas fa-exclamation-circle"></i> No reports have been assigned to your shelter.</p>
    <?php endif; ?>
</div>

<!-- footer from partials -->
<?php include('partials/footer_shelter.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
