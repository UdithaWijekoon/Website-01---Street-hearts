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
    <title>User Login</title>
    <link rel="stylesheet" href="../user/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: var(--secondary-clr);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background-color: var(--purple-white);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .image-section {
            width: 50%;
            background-image: url('login.jpg');
            background-size: cover;
            background-position: center;
        }

        .login-container {
            width: 50%;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 94%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid var(--primary-clr);
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: var(--secondary-clr);
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            cursor: pointer;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            display: inline-block;
            padding: 8px 15px;
            background-color: transparent;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .signup-link {
            margin-top: 15px;
            text-align: center;
        }

        .signup-link a {
            color: var(--primary-clr);
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
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

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert {
            padding: 15px 25px;
        }
        .back-to-home {
            margin-top: 20px;
            text-align: center;
        }

        .back-to-home a {
            color: var(--primary-clr);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-to-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Image section -->
    <div class="image-section"></div>

    <!-- Login form -->
    <div class="login-container">
        <h2>Log In to Your Account</h2>
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
        
        <form action="user_login_handler.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="forgot-password">
                <a href="user_forgot_password.php">Forgot Password?</a>
            </div>

            <button type="submit" class="btn primary-btn">Login</button>
        </form>

        <div class="signup-link">
            <p>New here? <a href="../user/signup_form.php">Sign up</a></p>
        </div>
        <!-- Back to Home Link -->
        <div class="back-to-home">
            <a href="../index.php">← Back to Home</a>
        </div>
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
