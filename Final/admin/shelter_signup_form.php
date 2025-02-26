<?php
// Database connection
include 'db_connect.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

//header from partials
include('partials/header_admin.php');

// Fetch districts
$sql = "SELECT DistrictID, DistrictName FROM districts";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Shelter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn2:hover {
            background-color: #0056b3;
        }

        .form-container .error {
            color: red;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1><i class="fas fa-home"></i> Register Shelter</h1>
    <form action="admin_create_shelter.php" method="POST">
        <label for="sheltername">Shelter Name:</label>
        <input type="text" id="sheltername" name="sheltername" required>
        
        <label for="email">Shelter Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone">
        
        <label for="district">District:</label>
        <select id="district" name="district" required>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['DistrictID'] . "'>" . $row['DistrictName'] . "</option>";
                }
            } else {
                echo "<option value=''>No Districts Available</option>";
            }
            ?>
        </select>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button class="btn2" type="submit">Register Shelter</button>
        <?php
        // Close the connection
        $conn->close();
        ?>
    </form>
</div>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>

</body>
</html>