<?php
include 'db_connect.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $pet_description = $_POST['pet_description'];
    $live_location_link = $_POST['live_location_link'];
    $location_description = $_POST['location_description']; // New field for location description
    $district = $_POST['district'];
    $additional_notes = $_POST['additional_notes'];

    // Check if 'uploads/' directory exists, if not create it
    $target_dir = "../uploads/reported_pets/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);  // Create the uploads directory if it doesn't exist
    }

    // Handle file upload for pet photo
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // Insert data into the database
        $sql = "INSERT INTO report (pet_description, photo_url, live_location_link, location_description, district, additional_notes)
                VALUES ('$pet_description', '$target_file', '$live_location_link', '$location_description', '$district', '$additional_notes')";

        if ($conn->query($sql) === TRUE) {
            $message = "New report submitted successfully!";
            $status = "success";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $status = "error";
        }
    } else {
        $message = "Failed to upload file.";
        $status = "error";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Pet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 18px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="message <?php echo $status; ?>">
    <?php echo $message; ?>
</div>

<a href="javascript:void(0);" onclick="goBack()" class="back-button">Back</a>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
