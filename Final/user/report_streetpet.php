<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Street Pet</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #cdc1ff;
        }
        .report-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 24px;
            background-color: #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        textarea, input[type="file"], input[type="url"], select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            color: #495057;
        }

        textarea:focus, input[type="file"]:focus, input[type="url"]:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        select {
            height: 40px;
        }

        .form-group {
            margin-bottom: 20px;
            width: 97%;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            textarea, input[type="file"], input[type="url"], select {
                font-size: 14px;
            }

            .submit-btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<?php
//header from partials
include('partials/header_user.php');
?>
<div class="report-container">
    <h2>Report a Street Pet</h2>
    <form action="submit_report.php" method="POST" enctype="multipart/form-data">
        <!-- Pet Description -->
        <div class="form-group">
            <label for="pet_description">Pet Description:</label>
            <textarea id="pet_description" name="pet_description" rows="4" cols="50" required></textarea>
        </div>

        <!-- Upload Photo of Pet -->
        <div class="form-group">
            <label for="photo">Upload Photo of Pet:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
        </div>

        <!-- Location Description -->
        <div class="form-group">
            <label for="location_description">Description of Location:</label>
            <textarea id="location_description" name="location_description" rows="4" cols="50" placeholder="Describe the location where the pet was found" required></textarea>
        </div>

        <!-- Live Location Link -->
        <div class="form-group">
            <label for="live_location_link">Location Link (Google Maps):</label>
            <input type="url" id="live_location_link" name="live_location_link" placeholder="Enter the location link" required>
        </div>

        <!-- Select District -->
        <div class="form-group">
            <label for="district">Select District:</label>
            <select id="district" name="district" required>
                <option value="">--Select District--</option>
                <option value="Ampara">Ampara</option>
                <option value="Anuradhapura">Anuradhapura</option>
                <option value="Badulla">Badulla</option>
                <option value="Batticaloa">Batticaloa</option>
                <option value="Colombo">Colombo</option>
                <option value="Galle">Galle</option>
                <option value="Gampaha">Gampaha</option>
                <option value="Hambantota">Hambantota</option>
                <option value="Jaffna">Jaffna</option>
                <option value="Kalutara">Kalutara</option>
                <option value="Kandy">Kandy</option>
                <option value="Kegalle">Kegalle</option>
                <option value="Kilinochchi">Kilinochchi</option>
                <option value="Kurunegala">Kurunegala</option>
                <option value="Mannar">Mannar</option>
                <option value="Matale">Matale</option>
                <option value="Matara">Matara</option>
                <option value="Monaragala">Monaragala</option>
                <option value="Mullaitivu">Mullaitivu</option>
                <option value="Nuwara Eliya">Nuwara Eliya</option>
                <option value="Polonnaruwa">Polonnaruwa</option>
                <option value="Puttalam">Puttalam</option>
                <option value="Ratnapura">Ratnapura</option>
                <option value="Trincomalee">Trincomalee</option>
                <option value="Vavuniya">Vavuniya</option>
            </select>
        </div>

        <!-- Additional Notes -->
        <div class="form-group">
            <label for="additional_notes">Additional Notes:</label>
            <textarea id="additional_notes" name="additional_notes" rows="4" cols="50"></textarea>
        </div>

        <!-- Submit Button -->
        <input type="submit" class="submit-btn btn primary-btn" value="Submit Report">
    </form>
</div>
<!-- Footer from partials -->
<?php include('partials/footer_user.php'); ?>
</body>
</html>

