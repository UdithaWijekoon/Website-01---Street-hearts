<?php
session_start();
$logoutMessage = $_SESSION['logout_message'] ?? null;
unset($_SESSION['logout_message']); // Remove the message after displaying it
$errorMessage = $_GET['error'] ?? null;

$message = $_SESSION['message'] ?? null; // Get success message if available
$error = $_SESSION['error'] ?? null;     // Get error message if available

// Clear the session messages after displaying them
unset($_SESSION['message']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            flex-direction: row;
        }

        .logo-section {
            background-color: #343a40;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 60px 40px 60px;
            flex: 1; 
        }

        .logo-section i {
            font-size: 100px;
        }

        .form-section {
            padding: 60px 120px 60px 120px;
            flex: 2; 
        }

        .form-section h2 {
            margin-bottom: 30px;
            color: #343a40;
            font-weight: bold;
        }

        .form-section .form-control {
            margin-bottom: 20px;
            padding: 15px;
            font-size: 16px;
        }

        .form-section button {
            width: 100%;
            padding: 15px;
            margin-top: 40px;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            border: none;
        }

        .form-section button:hover {
            background-color: #0056b3;
        }

        .form-section .input-group-text {
            background-color: #007bff;
            padding: 0px 15px ; 
            color: white;
            height: 46.6px;
            width: 46.6px;
        }
        .form-section .input-group .form-control {
            font-size: 16px; 
            padding: 10px 15px; 
        }
        
        .login-container .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .login-container .btn:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>

<div class="login-container">
    <!-- Logo Section -->
    <div class="logo-section">
        <i class="fas fa-user-shield"></i>
    </div>

    <!-- Form Section -->
    <div class="form-section">
        <h2><i class="fas fa-sign-in-alt"></i> Admin Login</h2>

        <!-- Display success message -->
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

        <form action="admin_login_handler.php" method="POST">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            
            <!-- Forgot Password Link -->
            <div class="text-end mb-3">
                <a href="admin_forgot_password.php" class="text-primary">Forgot your password?</a>
            </div>

            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
    </div>
</div>

<!-- Popup HTML element -->
<div id="popupAlert" class="popup-alert"></div>

<script>
window.onload = function() {
    <?php if ($logoutMessage): ?>
        showPopupAlert('<?php echo $logoutMessage; ?>', 'success');
    <?php elseif ($errorMessage == 'invalid'): ?>
        showPopupAlert('Invalid username or password.', 'error');
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

</body>
</html>
