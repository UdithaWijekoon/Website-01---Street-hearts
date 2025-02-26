<?php
// admin_approve_report.php

include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch pending reports
$sql = "SELECT * FROM report WHERE approval_status = 'pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pending_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch available shelters
$sqlShelters = "SELECT ShelterID, ShelterName FROM shelters";
$stmtShelters = $pdo->prepare($sqlShelters);
$stmtShelters->execute();
$shelters = $stmtShelters->fetchAll(PDO::FETCH_ASSOC);

// Fetch approved and rejected reports (report history)
$sqlHistory = "SELECT r.report_id, r.pet_description, r.photo_url, r.location_description, r.live_location_link, r.approval_status, s.ShelterName
               FROM report r
               LEFT JOIN shelters s ON r.shelter_id = s.ShelterID
               WHERE r.approval_status IN ('approved', 'rejected')";
$stmtHistory = $pdo->prepare($sqlHistory);
$stmtHistory->execute();
$report_history = $stmtHistory->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_id = $_POST['report_id'];
    $action = $_POST['action'];
    $shelter_id = $_POST['shelter_id'] ?? null;

    if ($action == 'approve' && $shelter_id) {
        // Approve the report and assign shelter
        $sqlUpdate = "UPDATE report SET approval_status = 'approved', shelter_id = :shelter_id WHERE report_id = :report_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        if ($stmtUpdate->execute(['report_id' => $report_id, 'shelter_id' => $shelter_id])) {
            $_SESSION['success_message'] = "Report approved successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to approve the report.";
        }
    } elseif ($action == 'reject') {
        // Reject the report
        $sqlUpdate = "UPDATE report SET approval_status = 'rejected' WHERE report_id = :report_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        if ($stmtUpdate->execute(['report_id' => $report_id])) {
            $_SESSION['success_message'] = "Report rejected successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to reject the report.";
        }
    } else {
        $_SESSION['error_message'] = "Please select a shelter for approval.";
    }

    // Redirect to avoid form resubmission
    header("Location: admin_approve_report.php");
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
    <title>Admin - Approve or Reject Reports</title>
    <style>
        body {
            background-color: #f8f9fa;  /* Light gray background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td img {
            width: 80px;
            border-radius: 5px;
        }

        td a {
            color: #007bff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Buttons */
        button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }

        button:hover {
            opacity: 0.9;
        }

        button[name="action"][value="approve"] {
            background-color: #28a745;
            color: white;
        }

        button[name="action"][value="reject"] {
            background-color: #dc3545;
            color: white;
        }

        select {
            padding: 5px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }

            td img {
                width: 60px;
            }

            button {
                font-size: 12px;
            }

            select {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            table, th, td {
                display: block;
                width: 100%;
                text-align: left;
            }

            th, td {
                padding: 10px;
                border: none;
                border-bottom: 1px solid #ddd;
            }

            td img {
                display: block;
                margin: 10px 0;
            }

            td:before {
                content: attr(data-label);
                font-weight: bold;
                margin-right: 10px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1><i class="fa fa-flag" aria-hidden="true"></i> Pending Street Pet Reports</h1>

    <?php
if (isset($_SESSION['success_message'])) {
    echo '<div style="color: green; text-align: center; margin-bottom: 20px;">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div style="color: red; text-align: center; margin-bottom: 20px;">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

    <?php if (!empty($pending_reports)): ?>
        <table>
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Location</th>
                    <th>Live Location Link</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_reports as $report): ?>
                    <tr>
                        <td data-label="Report ID"><?php echo htmlspecialchars($report['report_id']); ?></td>
                        <td data-label="Description"><?php echo htmlspecialchars($report['pet_description']); ?></td>
                        <td data-label="Photo"><img src="<?php echo htmlspecialchars($report['photo_url']); ?>" alt="Pet Photo"></td>
                        <td data-label="Location"><?php echo htmlspecialchars($report['location_description']); ?></td>
                        <td data-label="Live Location Link">
                            <a href="<?php echo htmlspecialchars($report['live_location_link']); ?>" target="_blank">View Location</a>
                        </td>
                        <td data-label="Action">
                            <form method="POST">
                                <input type="hidden" name="report_id" value="<?php echo $report['report_id']; ?>">
                                <select name="shelter_id" required>
                                    <option value="">Select Shelter</option>
                                    <?php foreach ($shelters as $shelter): ?>
                                        <option value="<?php echo $shelter['ShelterID']; ?>"><?php echo htmlspecialchars($shelter['ShelterName']); ?></option>
                                    <?php endforeach; ?>
                                    <option>Reject Report</option>
                                </select>
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending reports.</p>
    <?php endif; ?>

    <h1><i class="fa fa-history" aria-hidden="true"></i> Report History</h1>

    <?php if (!empty($report_history)): ?>
        <table>
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Location</th>
                    <th>Live Location Link</th>
                    <th>Status</th>
                    <th>Shelter</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report_history as $history): ?>
                    <tr>
                        <td data-label="Report ID"><?php echo htmlspecialchars($history['report_id']); ?></td>
                        <td data-label="Description"><?php echo htmlspecialchars($history['pet_description']); ?></td>
                        <td data-label="Photo"><img src="<?php echo htmlspecialchars($history['photo_url']); ?>" alt="Pet Photo"></td>
                        <td data-label="Location"><?php echo htmlspecialchars($history['location_description']); ?></td>
                        <td data-label="Live Location Link">
                            <a href="<?php echo htmlspecialchars($history['live_location_link']); ?>" target="_blank">View Location</a>
                        </td>
                        <td data-label="Status"><?php echo htmlspecialchars($history['approval_status']); ?></td>
                        <td data-label="Shelter"><?php echo htmlspecialchars($history['ShelterName'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No report history available.</p>
    <?php endif; ?>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>