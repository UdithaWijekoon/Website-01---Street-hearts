<?php
// add_success_story.php
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

$petID = $_GET['PetID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $story = $_POST['story'];

    try {
        // Insert the success story into the database
        $sql = "INSERT INTO success_stories (PetID, Title, Story) VALUES (:PetID, :Title, :Story)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['PetID' => $petID, 'Title' => $title, 'Story' => $story]);

        // Redirect with success message
        header("Location: admin_review_adoptions.php?status=success&message=Success%20story%20added%20successfully.");
        exit();
    } catch (PDOException $e) {
        // Redirect with error message
        header("Location: admin_review_adoptions.php?status=error&message=Error%20adding%20success%20story:%20" . urlencode($e->getMessage()));
        exit();
    }
}

// Fetch the pet's details
try {
    $stmt = $pdo->prepare("SELECT PetName FROM pets WHERE PetID = :PetID");
    $stmt->execute(['PetID' => $petID]);
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Success Story</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Add Success Story for <?php echo htmlspecialchars($pet['PetName']); ?></h1>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="story">Story:</label>
            <textarea name="story" id="story" rows="5" required></textarea>

            <button type="submit">Add Story</button>
        </form>

        <div class="back-link">
            <a href="admin_review_adoptions.php">← Back</a>
        </div>
    </div>


    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
