<!-- submit_volunteer.php -->
<?php
include 'db.php';

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $reason = $_POST['reason'];
    $skills = $_POST['skills'];

    try {
        $sql = "INSERT INTO volunteers (FirstName, LastName, Email, Phone, Address, ReasonForVolunteering, Skills)
                VALUES (:firstName, :lastName, :email, :phone, :address, :reason, :skills)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':reason' => $reason,
            ':skills' => $skills
        ]);
        $message = "Your volunteer request has been submitted!";
        $status = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Submission</title>
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
