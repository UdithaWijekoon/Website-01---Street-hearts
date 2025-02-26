<?php
// Include database connection
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

// Set default values for the filters
$petType = $_GET['pet-type'] ?? 'all';
$age = $_GET['age'] ?? 'any';
$gender = $_GET['gender'] ?? 'any';
$location = $_GET['location'] ?? 'any';

// Build the query with filters
$sql = "SELECT * FROM pets WHERE Status = 'Available'";

// Apply filters
if ($petType !== 'all') {
    $sql .= " AND PetType = :petType";
}
if ($age !== 'any') {
    if ($age === 'puppy-kitten') {
        $sql .= " AND Age < 1";
    } elseif ($age === 'young') {
        $sql .= " AND Age >= 1 AND Age < 3";
    } elseif ($age === 'adult') {
        $sql .= " AND Age >= 3 AND Age < 7";
    } elseif ($age === 'senior') {
        $sql .= " AND Age >= 7";
    }
}
if ($gender !== 'any') {
    $sql .= " AND Gender = :gender";
}
if ($location !== 'any') {
    $sql .= " AND Location = :location";
}

try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    if ($petType !== 'all') {
        $stmt->bindParam(':petType', $petType);
    }
    if ($gender !== 'any') {
        $stmt->bindParam(':gender', $gender);
    }
    if ($location !== 'any') {
        $stmt->bindParam(':location', $location);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching pets: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Search and Filter | Street Hearts</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f9;
        }

        a {
            color: white;
            text-decoration: none;
        }

        /* Hero Section */
        #hero {
            background-image: url('hero-image.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            background-color: var(--purple-white);
        }

        .hero-content {
            max-width: 600px;
            margin: 0 auto;
        }


        /* Filter Form */
        #search-filters {
            background-color: var(--secondary-clr);
            padding: 40px 20px;
        }

        .filter-form {
            display: flex;
            gap: 20px;
            width: 100%;
        }

        .filter-group {
            flex: 1 1 30%;
        }

        .filter-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: var(--purple-black);
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-clr);
            border-radius: 4px;
            font-size: 16px;
        }

        .search-btn {
            display: block;
            margin-top: 20px;
            width: 30%;
        }

        /* Pet Cards */
        .search-results{
            flex-direction: column;
        }

        .result-content {
            text-align: center;
        }

        .pet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            justify-items: center;
        }

        .pet-card {
            background-color: var(--purple-white);
            border: 2px solid var(--secondary-clr);
            border-radius: 8px;
            padding: 36px;
            text-align: center;
            max-width: 250px
        }

        .pet-card img {
            width: 100%;
            max-width: 200px; /* Set a fixed width */
            height: 200px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image fits within the given dimensions without distortion */
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .pet-card h3 {
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-group {
                flex: 1 1 100%;
            }

            .filter-group {
                display: flex;
                flex: 1 1 100%;
                flex-wrap: wrap;
            }

            .filter-form {
                display: flex;
                gap: 20px;
                flex-direction: column;
            }

            .cta-btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php
//header from partials
include('partials/header_user.php');
?>

<!-- Hero Section -->
<section id="hero">
    <div class="hero-content">
        <h1>Find Your Perfect Companion</h1>
        <p>Use our advanced search tools to find a street pet who’s ready to join your family.</p>
    </div>
</section>

<!-- Search Filters Section -->
<section id="search-filters">
    <div class="container">

        <form class="filter-form" method="GET" action="">
            <div class="filter-group">
                <label for="pet-type">Pet Type:</label>
                <select id="pet-type" name="pet-type">
                    <option value="all">All</option>
                    <option value="Dog" <?php if ($petType == 'Dog') echo 'selected'; ?>>Dogs</option>
                    <option value="Cat" <?php if ($petType == 'Cat') echo 'selected'; ?>>Cats</option>
                    <option value="Other" <?php if ($petType == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="age">Age:</label>
                <select id="age" name="age">
                    <option value="any">Any</option>
                    <option value="puppy-kitten" <?php if ($age == 'puppy-kitten') echo 'selected'; ?>>Puppy/Kitten</option>
                    <option value="young" <?php if ($age == 'young') echo 'selected'; ?>>Young</option>
                    <option value="adult" <?php if ($age == 'adult') echo 'selected'; ?>>Adult</option>
                    <option value="senior" <?php if ($age == 'senior') echo 'selected'; ?>>Senior</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="any">Any</option>
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="location">Location:</label>
                <select id="location" name="location">
                    <option value="any">Any</option>
                    <option value="colombo" <?php if ($location == 'colombo') echo 'selected'; ?>>Colombo</option>
                    <option value="kandy" <?php if ($location == 'kandy') echo 'selected'; ?>>Kandy</option>
                    <option value="badulla" <?php if ($location == 'badulla') echo 'selected'; ?>>Badulla</option>
                </select>
            </div>

            <button type="submit" class="btn primary-btn search-btn">Search</button>
        </form>
    </div>
</section>

<!-- Search Results Section -->
<section>
    <div class="search-results container">
        <div class="result-content">
            <h2>Meet Our Pets</h2>
            <p>Here are the pets that match your search. Click on a pet’s profile to learn more and start the adoption process.</p>
        </div>
        <div class="pet-grid">
            <?php if (!empty($pets)): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="pet-card">
                        <img src="../uploads/pet_profiles/<?php echo htmlspecialchars($pet['ProfilePicture']); ?>" alt="<?php echo htmlspecialchars($pet['PetName']); ?>">
                        <h3><?php echo htmlspecialchars($pet['PetName']); ?></h3>
                        <p>Type: <?php echo htmlspecialchars($pet['PetType']); ?></p>
                        <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
                        <p>Age: <?php echo htmlspecialchars($pet['Age']); ?> years</p>
                        <p>Gender: <?php echo htmlspecialchars($pet['Gender']); ?></p>
                        <p>Status: <?php echo htmlspecialchars($pet['HealthStatus']); ?></p>
                        <a href="pet_profile.php?PetID=<?php echo $pet['PetID']; ?>" class="btn secondary-btn">View Profile</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No pets available for adoption at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

 <!-- Footer from partials -->
 <?php include('partials/footer_user.php'); ?>

</body>
</html>
