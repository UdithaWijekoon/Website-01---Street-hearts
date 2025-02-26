<?php
include 'db.php';
session_start();

// Fetch UserID from session
$userID = $_SESSION['UserID'] ?? null;

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !$userID) {
    header("Location: ../login/user_login.php");
    exit();
}

try {
    // Fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = :UserID");
    $stmt->execute(['UserID' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

    // Fetch saved pets for the user
    $stmt = $pdo->prepare("
        SELECT p.* 
        FROM pets p
        JOIN saved_pets sp ON p.PetID = sp.PetID
        WHERE sp.UserID = :UserID
    ");
    $stmt->execute(['UserID' => $userID]);
    $savedPets = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>

        body {
            background-color: var(--accent-clr);
        }

        .profile-container {
            max-width: 720px;
            margin: 40px auto;
            padding: 36px;
            background-color: var(--secondary-clr);
            border-radius: 18px;
        }
        .profile-img {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-details {
            text-align: center;
        }
        
        .favorite-pets {
            margin-top: 40px;
        }

        .favorite-pets h2 {
            margin-bottom: 48px;
            text-align: center;
        }
        
        .pets-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .pet-card {
            background-color: var(--purple-white);
            font-color: var(--purple-white);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 250px;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s ease;
        }

        .pet-card:hover {
            transform: translateY(-5px);
        }

        .pet-card h4 {
            margin-bottom: 10px;
        }

        .pet-card p {
            margin: 5px 0;
        }

        .no-favorites {
            text-align: center;
        }

        .edit-profile {
            margin-top: 40px;
        }

        .form-group {
            margin-bottom: 15px;
            width: 97%;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
            /* align-items: stretch; */
        }
        
        /* Messages Section */

        .messages-container h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        .messages-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .messages-table th, .messages-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid var(--purple-black);
        }
        .messages-table th {
            background-color: var(--purple-black);
            color: var(--purple-white);
        }
        .messages-table td {
            background-color:var(--purple-white);
        }
        .no-messages {
            text-align: center;
        }
    </style>
</head>
<body>
    
<?php
//header from partials
include('partials/header_user.php');
?>

<div class="profile-container">
    <!-- User Profile Section -->
    <div class="profile-details">
        <h2>User Profile</h2>
        <img src="<?php echo htmlspecialchars($user['ProfilePicture']); ?>" alt="Profile Picture" class="profile-img">
        <h3><?php echo htmlspecialchars($user['Username']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($user['Email']); ?></p>
        <button class="btn primary-btn" onclick="scrollToEditProfile()">Edit Profile</button>
    </div>
</div>

<div class="profile-container favorite-pets">
    <!-- Favorite Pets Section -->
    <h2>Favorite Pets</h2>
    <div class="pets-container">
        <?php if ($savedPets): ?>
            <?php foreach ($savedPets as $pet): ?>
                <div class="pet-card">
                    <h4><?php echo htmlspecialchars($pet['PetName']); ?></h4>
                    <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
                    <p>Age: <?php echo htmlspecialchars($pet['Age']); ?></p>
                    <p>Gender: <?php echo htmlspecialchars($pet['Gender']); ?></p>
                    <p>Status: <?php echo htmlspecialchars($pet['Status']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-favorites">You have no favorite pets yet.</p>
        <?php endif; ?>
    </div>
</div>

<div class="profile-container messages-container">
    <!-- Messages from Admins Section -->
    <h3>Messages from Street Hearts Admin Panel</h3>
<?php
// Fetch messages for the logged-in user

$sql = "SELECT * FROM admin_messages 
        WHERE ReceiverUserID = :receiver_user_id 
        ORDER BY SentAt DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['receiver_user_id' => $userID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <?php if ($messages): ?>
        <table class="messages-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['Subject']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['MessageContent'])); ?></td>
                        <td><?php echo $message['SentAt']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-messages">No messages from admins yet.</p>
    <?php endif; ?>
</div>

<div class="profile-container edit-profile" id="editProfileSection">
    <!-- Edit Profile Section -->
    <h2>Edit Profile</h2>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <img src="<?php echo htmlspecialchars($user['ProfilePicture']); ?>" alt="Profile Picture" class="profile-img" id="profilePicturePreview">

        <div class="form-group">
            <label for="profilePicture">Change Profile Picture:</label>
            <input type="file" name="profilePicture" id="profilePicture" onchange="previewProfilePicture()">
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>

        <!-- Current Password Field -->
        <div class="form-group">
            <input type="password" name="currentPassword" hidden>
        </div>

        <!-- New Password Fields -->
        <div class="form-group">
            <label for="password">New Password (leave blank if not changing):</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" name="confirmPassword">
        </div>

        <input type="hidden" name="userID" value="<?php echo $userID; ?>">

        <button type="submit" class="btn primary-btn">Update Profile</button>
    </form>
</div>
<!-- Footer from partials -->
<?php include('partials/footer_user.php'); ?>
<script>
// JavaScript function to scroll to Edit Profile section
function scrollToEditProfile() {
    const editProfileSection = document.getElementById('editProfileSection');
    editProfileSection.scrollIntoView({ behavior: 'smooth' });
}

// JavaScript function to preview profile picture
function previewProfilePicture() {
    const input = document.getElementById('profilePicture');
    const preview = document.getElementById('profilePicturePreview');

    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result; // Set the image preview
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>

