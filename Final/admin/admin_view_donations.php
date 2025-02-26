<?php
include 'db.php';

session_start();

// Check if the admin is logged in (you should have a session or role check for admin)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php"); // Redirect to admin login page if not logged in
    exit();
}

//header from partials
include('partials/header_admin.php');

try {
    // Fetch all donations from the database
    $stmt = $pdo->prepare("SELECT d.DonationID, d.DonatorName, d.DonationAmount, d.PaymentReceipt, d.DonationDate, u.Username 
                           FROM donations d 
                           LEFT JOIN users u ON d.UserID = u.UserID 
                           ORDER BY d.DonationDate DESC");
    $stmt->execute();
    $donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error fetching donations: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Donations</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
            margin: 0;
            color: #333;
        }

        .table-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4C4D4C;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .receipt-link {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .receipt-link:hover {
            text-decoration: underline;
            color: #2980b9;
        }

        td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="table-container">
    <h2><i class="fas fa-donate"></i> Donations</h2>
    <table>
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Donator Name</th>
                <th>Username (if registered)</th>
                <th>Donation Amount</th>
                <th>Payment Receipt</th>
                <th>Donation Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($donations) > 0): ?>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($donation['DonationID']); ?></td>
                        <td><?php echo htmlspecialchars($donation['DonatorName']); ?></td>
                        <td><?php echo htmlspecialchars($donation['Username'] ?? 'Guest'); ?></td>
                        <td><?php echo htmlspecialchars($donation['DonationAmount']); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($donation['PaymentReceipt']); ?>" target="_blank" class="receipt-link">
                                View Receipt
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($donation['DonationDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No donations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
