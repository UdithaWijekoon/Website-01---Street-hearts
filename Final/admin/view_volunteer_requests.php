<!-- view_volunteer_requests.php -->
<?php
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
    // Fetch all volunteer requests
    $sql = "SELECT * FROM volunteers WHERE ApplicationStatus = 'Pending'";
    $stmt = $pdo->query($sql);
    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching volunteer requests: " . $e->getMessage();
}
?>

<!-- approved_volunteers.php -->
<?php
include 'db.php';

try {
    // Fetch all approved volunteers
    $sql = "SELECT * FROM volunteers WHERE ApplicationStatus = 'Approved'";
    $stmt = $pdo->query($sql);
    $approvedVolunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching approved volunteers: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd; /* Adds visible table lines */
        }

        table th, table td {
            padding: 15px;
            text-align: left;
        }

        table th {
            background-color: #4C4D4C;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9e9e9;
        }

        button {
            padding: 8px 15px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        button[name="action"][value="approve"] {
            background-color: #28a745;
            color: white;
        }

        button[name="action"][value="reject"] {
            background-color: #dc3545;
            color: white;
        }

        button:hover {
            opacity: 0.9;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }

            button {
                padding: 6px 10px;
                font-size: 12px;
            }
        }
        /*styles for messages */
        .alert-custom {
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Success message */
        .alert-success-custom {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        /* Error message */
        .alert-danger-custom {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Add icons for success and error messages */
        .alert-custom i {
            margin-right: 10px;
        }

        /* Adjust responsiveness */
        @media (max-width: 768px) {
            .alert-custom {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <!-- Success message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Error message -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <!-- Pending Volunteer Requests Section -->
    <h1><i class="fa fa-user" aria-hidden="true"></i> Pending Volunteer Requests</h1>
    
    <?php if (empty($volunteers)): ?>
        <div class="alert alert-info">
            No pending volunteer requests.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Reason</th>
                    <th>Skills</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($volunteers as $volunteer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Email']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Phone']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['ReasonForVolunteering']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Skills']); ?></td>
                        <td>
                            <form action="approve_volunteer.php" method="POST">
                                <input type="hidden" name="VolunteerID" value="<?php echo $volunteer['VolunteerID']; ?>">
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Approved Volunteers Section -->
    <h1><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved Volunteers</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Reason for Volunteering</th>
                <th>Skills</th>
                <th>Application Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approvedVolunteers)): ?>
                <?php foreach ($approvedVolunteers as $volunteer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($volunteer['FirstName'] . ' ' . $volunteer['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Email']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Phone']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['ReasonForVolunteering']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['Skills']); ?></td>
                        <td><?php echo htmlspecialchars($volunteer['ApplicationDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No approved volunteers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
