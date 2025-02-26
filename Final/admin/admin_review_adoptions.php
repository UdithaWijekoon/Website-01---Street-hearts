<!-- admin_review_adoptions.php -->
<?php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

//header from partials
include('partials/header_admin.php');

try {
    // Fetch all available and adopted pets
    $sql_pets = "SELECT * FROM pets WHERE Status IN ('Available', 'Adopted')";
    $stmt_pets = $pdo->query($sql_pets);
    $pets = $stmt_pets->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all pending adoption applications
    $sql_applications = "SELECT a.ApplicationID, a.PetID, a.UserID, a.ReasonForAdoption, a.Status, p.PetName, u.UserName 
                         FROM adoption_applications a
                         JOIN pets p ON a.PetID = p.PetID
                         JOIN users u ON a.UserID = u.UserID
                         WHERE a.Status = 'Pending'";
    $stmt_applications = $pdo->query($sql_applications);
    $applications = $stmt_applications->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Pets and Adoption Applications</title>
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
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn2 {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .approve-btn:hover {
            background-color: green;
        }
        .decline-btn:hover {
            background-color: red;
        }
        .approve-btn {
            background-color: #02AC0A;
        }
        .decline-btn {
            background-color: #f44336;
        }
        .adopted {
            background-color: lightgray;
        }
        .available {
            background-color: lightgreen;
        }
        h1{
            text-align: center;
        } 
        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }

            .btn2 {
                padding: 4px 8px;
                font-size: 12px;
            }

            /* Add table scroll for smaller screens */
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        /* Stack table rows on very small screens */
        @media (max-width: 576px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
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

            .btn2 {
                padding: 6px;
                font-size: 14px;
                text-align: center;
            }

            .approve-btn, .decline-btn {
                width: 100%;
                margin-top: 5px;
            }
        }
            .message {
                padding: 10px;
                margin-bottom: 15px;
                border-radius: 5px;
                font-size: 16px;
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

<h1><i class="fa fa-address-card" aria-hidden="true"></i> Adoption Application Management</h1>

<!-- Display success or error messages -->
<?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
    <div class="message <?php echo ($_GET['status'] === 'success') ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<h2>Available and Adopted Pets</h2>
<table>
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
        <?php if (!empty($pets)): ?>
            <?php foreach ($pets as $pet): ?>
                <tr class="<?php echo strtolower($pet['Status']); ?>">
                    <td><?php echo htmlspecialchars($pet['PetID']); ?></td>
                    <td><?php echo htmlspecialchars($pet['PetName']); ?></td>
                    <td><?php echo htmlspecialchars($pet['Breed']); ?></td>
                    <td><?php echo htmlspecialchars($pet['Age']); ?> years</td>
                    <td><?php echo htmlspecialchars($pet['Gender']); ?></td>
                    <td><?php echo htmlspecialchars($pet['Status']); ?></td>
                    <td>
                        <?php if ($pet['Status'] == 'Adopted'): ?>
                            <a href="add_success_story.php?PetID=<?php echo $pet['PetID']; ?>" class="btn2 approve-btn">Add to Success Stories</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No pets available or adopted at the moment.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h2>Pending Adoption Applications</h2>

<?php if (!empty($applications)): ?>
    <table>
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Pet Name</th>
                <th>Applicant</th>
                <th>Reason for Adoption</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo htmlspecialchars($application['ApplicationID']); ?></td>
                    <td><?php echo htmlspecialchars($application['PetName']); ?></td>
                    <td><?php echo htmlspecialchars($application['UserName']); ?></td>
                    <td><?php echo htmlspecialchars($application['ReasonForAdoption']); ?></td>
                    <td><?php echo htmlspecialchars($application['Status']); ?></td>
                    <td>
                        <a href="process_application.php?ApplicationID=<?php echo $application['ApplicationID']; ?>&action=approve" class="btn2 approve-btn">Approve</a>
                        <a href="process_application.php?ApplicationID=<?php echo $application['ApplicationID']; ?>&action=decline" class="btn2 decline-btn">Decline</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No pending applications.</p>
<?php endif; ?>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
