<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: var(--primary-clr);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-container {
            max-width: 600px;
            width: 100%;
            background-color: var(--purple-white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            margin: 36px auto;
        }

        .signup-container:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px; 
            font-size: 24px; 
            font-weight: bold; 
        }

        .form-group {
            width: 97%;
            padding-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid var(--purple-black);
            transition: border-color 0.3s;
        }


        /* Circular profile picture preview */
        .profile-picture-container {
            position: relative;
            width: 100px; 
            height: 100px;
            border-radius: 50%; 
            overflow: hidden; 
            background-color: var(--secondary-clr); 
            margin: 10px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            color: var(--purple-black);
            text-align: center;
        }

        #profile_picture_preview {
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: none; 
        }

        button {
            width: 100%;
        }

        .login-link {
            margin-top: 15px;
            text-align: center;
        }

        .login-link a {
            color: var(--primary-clr);
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            display: none;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .signup-container {
                padding: 20px;
                border-radius: 10px;
            }

            .profile-picture-container {
                width: 80px; 
                height: 80px;
            }
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

<div class="signup-container">
<h2>New Here? Sign Up</h2>
    <form id="signupForm" action="user_signup.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <div class="error" id="passwordError">Passwords do not match</div>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
        </div>

        <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(event)">
            <div class="profile-picture-container">
                <img id="profile_picture_preview" alt="Profile Picture Preview">
                <span id="placeholderText">Upload a picture</span>
            </div>
        </div>

        <button type="submit" class="btn primary-btn">Sign Up</button>
    </form>

    <div class="login-link">
        <p>Already have an account? <a href="../login/user_login.php">Login here</a></p>
    </div>
    <!-- Back to Home Link -->
    <div class="back-to-home">
            <a href="../index.php">← Back to Home</a>
    </div>
</div>

<script>
    // Function to preview the profile picture
    function previewImage(event) {
        const preview = document.getElementById('profile_picture_preview');
        const placeholder = document.getElementById('placeholderText');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none'; // Hide placeholder text
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'block'; // Show placeholder text
        }
    }

    // Validate password confirmation
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorDiv = document.getElementById('passwordError');

        if (password !== confirmPassword) {
            event.preventDefault(); // Prevent form submission
            errorDiv.style.display = 'block'; // Show error message
        } else {
            errorDiv.style.display = 'none'; // Hide error message
        }
    });
</script>

</body>
</html>
