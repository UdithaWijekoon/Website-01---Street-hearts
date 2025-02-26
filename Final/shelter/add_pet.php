<?php
// add_pet.php (Shelter Dashboard)
include 'db.php';
session_start();

// Check if the shelter is logged in
if (!isset($_SESSION['shelter_logged_in']) || $_SESSION['shelter_logged_in'] !== true) {
    header("Location: ../login/shelter_login.php");
    exit();
}

include('partials/header_shelter.php');

// Display success or error message
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

// Clear the messages after displaying them
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet - Shelter Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }
        .form-container {
            min-width: 600px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        footer {
            margin-top: 50px;
        }
        .alert {
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
    .form-container {
        min-width: 100%;
        padding: 15px;
    }

    h2 {
        font-size: 1.8rem;
    }

    label {
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        font-size: 0.9rem;
        padding: 0.75rem;
    }

    .btn {
        font-size: 0.9rem;
        padding: 0.6rem;
    }
}

@media (max-width: 576px) {
    .container {
        margin-top: 20px;
    }

    .form-container {
        padding: 10px;
        box-shadow: none;
    }

    h2 {
        font-size: 1.5rem;
    }

    .form-control, .form-select {
        font-size: 0.8rem;
        padding: 0.6rem;
    }

    .btn {
        font-size: 0.8rem;
        padding: 0.5rem;
    }
}

    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2><i class="fas fa-paw"></i> Add Pet</h2>

        <!-- Display Success Message -->
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Display Error Message -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="submit_pet.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="petType" class="form-label"><i class="fas fa-dog"></i> Pet Type</label>
                <select name="petType" id="petType" class="form-select" required>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="petName" class="form-label"><i class="fas fa-signature"></i> Pet Name</label>
                <input type="text" name="petName" id="petName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="breed" class="form-label"><i class="fas fa-dna"></i> Breed</label>
                <input type="text" name="breed" id="breed" class="form-control">
            </div>

            <div class="mb-3">
                <label for="age" class="form-label"><i class="fas fa-birthday-cake"></i> Age (Years)</label>
                <input type="number" name="age" id="age" class="form-control" min="0">
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label"><i class="fas fa-venus-mars"></i> Gender</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Unknown">Unknown</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="size" class="form-label"><i class="fas fa-ruler"></i> Size</label>
                <select name="size" id="size" class="form-select" required>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label"><i class="fas fa-palette"></i> Color</label>
                <input type="text" name="color" id="color" class="form-control">
            </div>

            <div class="mb-3">
                <label for="healthStatus" class="form-label"><i class="fas fa-heartbeat"></i> Health Status</label>
                <input type="text" name="healthStatus" id="healthStatus" class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label"><i class="fas fa-align-left"></i> Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label"><i class="fas fa-map-marker-alt"></i> Location</label>
                <input type="text" name="location" id="location" class="form-control">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label"><i class="fas fa-flag"></i> Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Available">Available</option>
                    <option value="Adopted">Adopted</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="profilePicture" class="form-label"><i class="fas fa-camera"></i> Profile Picture</label>
                <input type="file" name="profilePicture" id="profilePicture" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Submit Pet</button>
            </div>
        </form>
    </div>
</div>

<?php include('partials/footer_shelter.php'); ?>
