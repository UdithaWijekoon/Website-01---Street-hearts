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

// Fetch the total number of received reports
$sqlReportsCount = "SELECT COUNT(*) AS total_reports FROM report WHERE shelter_id = :shelter_id";
$stmtReportsCount = $pdo->prepare($sqlReportsCount);
$stmtReportsCount->execute(['shelter_id' => $shelterID]);
$reportCountData = $stmtReportsCount->fetch(PDO::FETCH_ASSOC);

// Fetch the total number of pets added
$sqlPetsCount = "SELECT COUNT(*) AS total_pets FROM pets WHERE ShelterID = :shelter_id";
$stmtPetsCount = $pdo->prepare($sqlPetsCount);
$stmtPetsCount->execute(['shelter_id' => $shelterID]);
$petCountData = $stmtPetsCount->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelter Dashboard</title>


<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
        body {
            background-color: #f8f9fa;  /* Light gray background */
            font-family: Arial, sans-serif;

        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #343a40;
            letter-spacing: 1.5px;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }

        .stat-box {
            flex: 1;
            margin: 15px;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-box:hover {
            transform: scale(1.05);
        }

        .stat-box h2 {
            font-size: 3.5em;
            margin: 0;
            color: #343a40;
        }

        .stat-box p {
            font-size: 1.3em;
            color: #6c757d;
            margin-top: 10px;
        }

        .icon {
            font-size: 4em;
            color: #007bff;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
        }
        @media (max-width: 768px) {
    /* Stack the stats boxes vertically on smaller screens */
    .stats-container {
        flex-direction: column;
        align-items: center;
    }

    .stat-box {
        width: 80%;  
        margin: 20px 0;  
        padding: 30px;  
    }

    .stat-box h2 {
        font-size: 2.5em;  
    }

    .stat-box p {
        font-size: 1.1em;  
    }

    .icon {
        font-size: 3em;  
    }
}

@media (max-width: 576px) {
    /* Further adjustments for very small screens */
    .stat-box {
        width: 90%;  
        padding: 20px;  
    }

    .stat-box h2 {
        font-size: 2em; 
    }

    .stat-box p {
        font-size: 1em;  
    }

    .icon {
        font-size: 2.5em;  
    }
}
.popup-alert {
            display: none;
            position: fixed;
            top: 5%;
            left: 50%;
            transform: translateX(-50%);
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
/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .login-container {
        flex-direction: column; 
        max-width: 500px; 
    }

    .logo-section {
        padding: 20px 40px;
    }

    .form-section {
        padding: 40px;
    }
}

@media (max-width: 576px) {
    .form-section {
        padding: 20px; 
    }

    .form-section h2 {
        font-size: 24px;
    }

    .form-section .form-control {
        padding: 10px; 
        font-size: 14px;
    }

    .form-section button {
        padding: 12px;
        font-size: 16px;
    }

    .logo-section i {
        font-size: 60px; 
    }
}
.col-md-6 .stat-box i{
    color: #19B340;
}

</style>
</head>
<body> 

<div class="container">
    <h1>Welcome to the Shelter Dashboard!</h1>

    <!-- Popup alert -->
    <div id="popupAlert" class="popup-alert"></div>

    <div class="row stats-container">
        <!-- Total Reports -->
        <div class="col-md-6">
            <div class="stat-box">
                <i class="fas fa-file-alt icon"></i>
                <h2><?php echo $reportCountData['total_reports']; ?></h2>
                <p>Total Reports Received</p>
            </div>
        </div>

        <!-- Total Pets Added -->
        <div class="col-md-6">
            <div class="stat-box">
                <i class="fas fa-paw icon"></i>
                <h2><?php echo $petCountData['total_pets']; ?></h2>
                <p>Total Pets Added</p>
            </div>
        </div>
    </div>
</div>

<!-- footer from partials -->
<div class="footer">
    <?php include('partials/footer_shelter.php'); ?>
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
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
