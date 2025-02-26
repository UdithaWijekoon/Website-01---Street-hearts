<?php
// pet_profile.php

include 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

if (isset($_GET['PetID']) && !empty($_GET['PetID'])) {
    $petID = $_GET['PetID'];

    try {
        // Query to fetch pet details based on PetID
        $sql = "SELECT * FROM pets WHERE PetID = :PetID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['PetID' => $petID]);

        // Fetch the pet details
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if pet data exists
        if (!$pet) {
            echo "Pet not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching pet details: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid pet ID.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pet['PetName']); ?> - Pet Profile</title>
    <style>
        :root {
            --primary-clr: #7E60BF;
            --secondary-clr: #CDC1FF;
            --accent-clr: #433878;
            --purple-black: #17153B;
            --purple-white: #F5EFFF;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: var(--accent-clr);
        }

        .btn {
            font-family: 'Open Sans', sans-serif;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 12px;
            border: solid 2px var(--primary-clr);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .primary-btn {
            background-color: var(--primary-clr);
            color: var(--purple-white);
        }

        .secondary-btn {
            background-color: var(--purple-white);
            color: var(--primary-clr);
        }

        .primary-btn:hover {
            background-color: var(--accent-clr);
        }

        .secondary-btn:hover {
            background-color: var(--accent-clr);
            color: var(--purple-white);
        }

        .profile-btn {
            display: flex;
            gap: 32px;
        }

        /* typography */

        h1, h2, h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--purple-black);
        }

        p{
            font-family: 'Open Sans', sans-serif;
            color: var(--purple-black);
            font-size: 18px;
            line-height: 26px;
            margin: 12px 0;
        }

        h1 {
            font-size: 40px;
            line-height: 48px;
            margin: 36px 0;
        }

        h2 {
            font-size: 32px;
            margin: 24px 0;
        }

        h3 {
            font-size: 24px;
            margin: 12px 0;
        }


        .profile-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: var(--purple-white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-header img {
            max-width: 200px;
            border-radius: 8px;
            margin-right: 20px;
        }

    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <img src="../uploads/pet_profiles/<?php echo htmlspecialchars($pet['ProfilePicture']); ?>" alt="<?php echo htmlspecialchars($pet['PetName']); ?>">
        <div>
            <h2><?php echo htmlspecialchars($pet['PetName']); ?></h2>
            <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
            <p>Age: <?php echo htmlspecialchars($pet['Age']); ?> years</p>
            <p>Gender: <?php echo htmlspecialchars($pet['Gender']); ?></p>
        </div>
    </div>

    <div class="profile-details">
        <h2>Details</h2>
        <p><strong>Size:</strong> <?php echo htmlspecialchars($pet['Size']); ?></p>
        <p><strong>Color:</strong> <?php echo htmlspecialchars($pet['Color']); ?></p>
        <p><strong>Health Status:</strong> <?php echo htmlspecialchars($pet['HealthStatus']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($pet['Description']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['Location']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($pet['Status']); ?></p>
    </div>

    <div class="profile-btn">
        <a href="adoption_form.php?PetID=<?php echo $pet['PetID']; ?>" class="btn primary-btn">Adopt <?php echo htmlspecialchars($pet['PetName']); ?></a>

        <form action="add_to_favorites.php"     method="POST">
            <input type="hidden" name="PetID" value="<?php echo $petID; ?>">
            <button type="submit" class="btn secondary-btn">Add to Favorites</button>
        </form>

        <a href="javascript:history.back()" class="btn secondary-btn">Go Back</a>

    </div>

</div>

</body>
</html>

