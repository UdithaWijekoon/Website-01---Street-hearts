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

// Fetch adoption analytics data
$sqlAdoptions = "SELECT COUNT(*) AS total_adoptions, 
                        SUM(CASE WHEN Status = 'Adopted' THEN 1 ELSE 0 END) AS adopted,
                        SUM(CASE WHEN Status = 'Available' THEN 1 ELSE 0 END) AS available
                 FROM pets";
$stmtAdoptions = $pdo->prepare($sqlAdoptions);
$stmtAdoptions->execute();
$adoptionData = $stmtAdoptions->fetch(PDO::FETCH_ASSOC);

// Fetch reports analytics data
$sqlReports = "SELECT COUNT(*) AS total_reports,
                      SUM(CASE WHEN approval_status = 'approved' THEN 1 ELSE 0 END) AS approved_reports,
                      SUM(CASE WHEN approval_status = 'rejected' THEN 1 ELSE 0 END) AS rejected_reports,
                      SUM(CASE WHEN approval_status = 'pending' THEN 1 ELSE 0 END) AS pending_reports
               FROM report";
$stmtReports = $pdo->prepare($sqlReports);
$stmtReports->execute();
$reportData = $stmtReports->fetch(PDO::FETCH_ASSOC);

// Fetch total users
$sqlUsers = "SELECT COUNT(*) AS total_users FROM users";
$stmtUsers = $pdo->prepare($sqlUsers);
$stmtUsers->execute();
$userData = $stmtUsers->fetch(PDO::FETCH_ASSOC);

// Fetch total shelters
$sqlShelters = "SELECT COUNT(*) AS total_shelters FROM shelters";
$stmtShelters = $pdo->prepare($sqlShelters);
$stmtShelters->execute();
$shelterData = $stmtShelters->fetch(PDO::FETCH_ASSOC);

// Fetch total admins
$sqlAdmins = "SELECT COUNT(*) AS total_admins FROM admins";
$stmtAdmins = $pdo->prepare($sqlAdmins);
$stmtAdmins->execute();
$adminData = $stmtAdmins->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
    /* Body styling to match the admin dashboard theme */
    body {
        background-color: #f8f9fa;  /* Light gray background */
        font-family: Arial, sans-serif;
    }

    .container {
        margin-top: 20px;
    }

    h1{
        letter-spacing: 1.5px;
    }
    h1, h2 {
        color: #343a40;
        text-align: center;
    }
    h2 {
        margin-top: 50px;
    }
    /* Styling for the statistics section */
    .stats-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 20px 0;
    }

    .stat-box {
        background-color: #ffffff;
        padding: 30px; 
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 250px; 
        transition: transform 0.3s;
    }

    .stat-box:hover {
        transform: scale(1.1);
    }

    .stat-box h2 {
        font-size: 48px; 
        color: #007bff;  
        margin-bottom: 5px;
    }

    .stat-box p {
        color: #6c757d;  
        font-size: 18px;
        margin-top: 0;
    }

    .stat-box i {
        font-size: 40px; 
        color: #007bff; 
        margin-bottom: 10px;
    }

    .popup-alert {
        display: none;
        position: fixed;
        top: 5%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        padding: 15px 25px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        min-width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fade-in 0.5s ease-in-out, fade-out 5s 0.5s ease-in forwards;
        }
        /* fade-in animation (from top to down) */
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Fade-out animation */
        @keyframes fade-out {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    .popup-alert.success {
        background-color: #d4edda;
        color: #155724;
    }
    .popup-alert.error {
        background-color: #f8d7da;
        color: #721c24;
    }


    /* Chart container for analytics */
    .chart-container {
        background-color: #ffffff;
        padding: 20px;
        margin-top: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Adjusting layout for smaller devices */
    @media (max-width: 767px) {
        .stats-container {
            flex-direction: column;
            align-items: center;
        }

        .stat-box {
            margin-bottom: 20px;
            width: 100%;
            max-width: 300px;
        }

        .chart-container {
            width: 100%;
        }
    }
</style>
</head>
<body>

<div class="container">
    <h1>Welcome to the Admin Dashboard!</h1>

    <!-- Popup alert -->
    <div id="popupAlert" class="popup-alert"></div>

<!-- Statistics Section -->
<div class="stats-container">
    <div class="stat-box">
        <i class="fas fa-user-shield"></i>
        <h2><?php echo $adminData['total_admins']; ?></h2>
        <p>Total Admins</p>
    </div>
    <div class="stat-box">
        <i class="fas fa-users"></i> 
        <h2><?php echo $userData['total_users']; ?></h2>
        <p>Total Users</p>
    </div>
    <div class="stat-box">
        <i class="fas fa-home"></i> 
        <h2><?php echo $shelterData['total_shelters']; ?></h2>
        <p>Total Shelters</p>
    </div>
</div>

<!-- Adoption Analytics Section -->
<h2><i class="fa fa-pie-chart" aria-hidden="true"></i> Adoption Analytics</h2>
<div class="chart-container">
    <canvas id="adoptionPieChart"></canvas>
</div>

<!-- Reporting Analytics Section -->
<h2><i class="fa fa-bar-chart" aria-hidden="true"></i> Reporting Analytics</h2>
<div class="chart-container">
    <canvas id="reportBarChart"></canvas>
</div>

<!-- Total Statistics Section -->
<h2><i class="fa fa-bar-chart" aria-hidden="true"></i> Total Members</h2>
<div class="chart-container">
    <canvas id="totalStatsBarChart"></canvas>
</div>

<script>
    window.onload = function() {
        <?php if (isset($_SESSION['login_message'])): ?>
            showPopupAlert('<?php echo $_SESSION['login_message']; ?>', '<?php echo $_SESSION['login_message_type']; ?>');
            <?php unset($_SESSION['login_message']); ?>
        <?php endif; ?>
    };

    function showPopupAlert(message, type) {
        var popup = document.getElementById('popupAlert');
        popup.innerHTML = message;
        popup.className = 'popup-alert ' + (type === 'success' ? 'success' : 'error');
        popup.style.display = 'block';
        
        // Hide the popup after 5 seconds
        setTimeout(function() {
            popup.style.display = 'none';
        }, 5000);
    }
</script>

<script>
// Adoption Pie Chart
const adoptionCtx = document.getElementById('adoptionPieChart').getContext('2d');
const adoptionPieChart = new Chart(adoptionCtx, {
    type: 'pie',
    data: {
        labels: ['Adopted Pets', 'Available Pets'],
        datasets: [{
            data: [<?php echo $adoptionData['adopted']; ?>, <?php echo $adoptionData['available']; ?>],
            backgroundColor: ['#4CAF50', '#FFC107'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

// Reporting Bar Chart
const reportCtx = document.getElementById('reportBarChart').getContext('2d');
const reportBarChart = new Chart(reportCtx, {
    type: 'bar',
    data: {
        labels: ['Approved Reports', 'Rejected Reports', 'Pending Reports'],
        datasets: [{
            label: 'Reports',
            data: [<?php echo $reportData['approved_reports']; ?>, <?php echo $reportData['rejected_reports']; ?>, <?php echo $reportData['pending_reports']; ?>],
            backgroundColor: ['#4CAF50', '#F44336', '#FFC107'],
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Total Statistics Bar Chart
const totalStatsCtx = document.getElementById('totalStatsBarChart').getContext('2d');
const totalStatsBarChart = new Chart(totalStatsCtx, {
    type: 'bar',
    data: {
        labels: ['Admins', 'Users', 'Shelters'],
        datasets: [{
            label: 'Total Counts',
            data: [<?php echo $adminData['total_admins']; ?>, <?php echo $userData['total_users']; ?>, <?php echo $shelterData['total_shelters']; ?>],
            backgroundColor: ['#4CAF50', '#2196F3', '#FFC107'],
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
<!-- Bootstrap JS -->
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>  
