<?php
// Database connection
include 'db_connect.php';

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
  <title>Street Hearts - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>

    /* Hero Section */
    .hero {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: var(--purple-white);
    }

    .hero-content {
      display: flex;
      flex-direction: column;
      width: 50%;
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
      flex-direction: row;
    }

    .hero-img {
      margin-left: 36px;
      width: 60%;
    }

   /* About Section */
   .about-content {
      width: 60%;
    }

    .about {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    .about img{
      margin-right: 36px;
      width: 40%
    }

    /* Featured Pets Section */
    .featured-pets {
      text-align: center;
    }

    .pet-carousel {
      display: flex;
      padding: 60px 0;
      justify-content: space-between;
    }

    .pet-card {
      background-color: var(--purple-white);
      border: 1px solid var(--primary-clr);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      width: 280px;
    }

    .pet-card img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .pet-card h3 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .pet-card p {
      font-size: 16px;
      margin: 5px 0;
    }

    .view-profile-btn {
      display: inline-block;
      margin-top: 10px;
    }

    /* Mobile Responsive Design */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 32px;
        line-height: 40px;
      }

      .hero-buttons {
        flex-direction: column;
        gap: 10px;
      }

      .pet-card {
        width: 100%;
      }
    }

    /* Community Engagement Section */
    .community-engagement {
      padding: 50px 20px;
      background-color: var(--purple-white);
      text-align: center;
    }

    .community-engagement h2 {
      font-size: 32px;
      margin-bottom: 20px;
    }

    .community-engagement p {
      font-size: 18px;
      line-height: 26px;
      margin-bottom: 40px;
    }

    .community-content {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .event {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .event-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .event-card {
      background-color: var(--purple-white);
      border: 2px solid var(--primary-clr);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      width: 300px;
    }

    .event-card h3 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .event-card p {
      font-size: 16px;
      margin-bottom: 20px;
    }


    /* Mobile Responsive Design */
    @media (max-width: 768px) {
      .event-list {
        flex-direction: column;
      }

      .event-card {
        width: 100%;
      }
    }
  
    /* Navbar Styles */
    .navbar {
      background-color: var(--primary-clr);
      color: var(--pure-white);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }


    .logo a {
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      font-size: 24px;
      color: var(--pure-white);
      text-decoration: none;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .nav-links li {
      margin: 0;
    }

    .nav-links a {
      color: var(--pure-white);
      text-decoration: none;
      font-size: 16px;
      font-weight: 400;
    }

    .nav-links a:hover {
      color: var(--secondary-clr);
    }

    .nav-links .profile-icon img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }

    /* Login Button */
    .nav-links .login-button {
      background-color: var(--secondary-clr);
      color: var(--purple-black);
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
    }

    .nav-links .login-button:hover {
      background-color: var(--accent-clr);
      color: var(--pure-white);
    }

    /* Hamburger Menu */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: none;
      border: none;
      cursor: pointer;
    }

    .hamburger .bar {
      width: 25px;
      height: 3px;
      background-color: var(--pure-white);
      border-radius: 3px;
      transition: 0.3s;
    }

    /* Feedback Section Styling */

    .feedback-container {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {

      .container{
        flex-direction: row;
      }
      .nav-links {
        display: none;
      }

      .nav-links.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 40px;
        right: 0;
        background-color: var(--primary-clr);
        padding: 20px;
        width: 60%;
        z-index: 1;
    }

      .hamburger {
        display: flex;
      }
    }
    .popup-alert {
        display: none;
        position: fixed;
        top: 5%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        padding: 15px 25px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        min-width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fade-in 0.5s ease-in-out, fade-out 5s 0.5s ease-in forwards;
        }
        /* fade-in animation (from top to down) */
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Fade-out animation */
        @keyframes fade-out {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    .popup-alert.success {
        background-color: #d4edda;
        color: #155724;
    }
    .popup-alert.error {
        background-color: #f8d7da;
        color: #721c24;
    }
  </style>
</head>
<body>

<?php
//header from partials
include('partials/header_user.php');
?>
<!-- Popup alert -->
<div id="popupAlert" class="popup-alert"></div>
  <!-- Hero Section -->
  <section class="hero" >
    <div class="container">
      <div class="hero-content">
        <h1>Give a Home to a Street Pet – Save a Life Today</h1>
        <p>Join us in our mission to provide shelter, care, and love to every street animal.</p>
        <div class="hero-buttons">
          <a href="pet_page.php" class="btn primary-btn">Find Your Perfect Companion</a>
          <a href="report_streetpet.php" class="btn secondary-btn">Report a Street Pet</a>
        </div>
      </div>
      <div class="hero-img">
        <img src="assests\home.jpg" alt="hero img">
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section>
    <div class="about container">
      <img src="assests/home_hero.jpg" alt="about image">
      <div class="about-content">
        <h2>About Street Hearts</h2>
        <p>At Street Hearts, we believe that every street animal deserves love, care, and a safe home. We are a community-driven organization dedicated to rescuing, rehabilitating, and rehoming street pets while promoting compassionate and responsible pet ownership.</p>
        <a href="about.php" class="btn primary-btn">Learn More</a>
      </div>
    </div>
  </section>

  
  <!-- Featured Pets Section -->
<section class="featured-pets">
  <h2>Meet Our Stars – Pets Looking for Homes</h2>
  <?php
  // Query to fetch the latest 3 available pets
$sql = "SELECT PetID, PetName, Age, Breed, ProfilePicture 
FROM pets 
WHERE Status = 'Available' 
ORDER BY CreatedAt DESC 
LIMIT 3";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
// Fetch the data
$pets = [];
while($row = $result->fetch_assoc()) {
$pets[] = $row;
}
} else {
echo "No pets available.";
}

?>
  <div class="pet-carousel container">
    <?php foreach ($pets as $pet) : ?>
    <div class="pet-card">
      <img src="../uploads/pet_profiles/<?php echo htmlspecialchars($pet['ProfilePicture']); ?>" alt="<?php echo htmlspecialchars($pet['PetName']); ?>">
      <h3><?php echo htmlspecialchars($pet['PetName']); ?></h3>
      <p>Age: <?php echo htmlspecialchars($pet['Age']); ?> years</p>
      <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
      <!-- Pass PetID to the pet profile page -->
      <a href="pet_profile.php?PetID=<?php echo $pet['PetID']; ?>" class="btn view-profile-btn secondary-btn">View Profile</a>
    </div>
    <?php endforeach; ?>
  </div>
  <a href="pet_page.php" class="btn primary-btn">See All Available Pets</a>
</section>

  <!-- Community Engagement Section -->
  <section class="community-engagement">
    <div class="community-content container">
      <h2>Join the Street Hearts Community</h2>
      <p>Stay connected with like-minded animal lovers and help street pets by volunteering, attending events, or spreading the word.</p>
      <a href="community.php" class="btn primary-btn">Community</a>
    </div>
  </section>

  <section class="event container">
    <h2>Upcoming Events</h2>
    <?php

// Query to fetch the latest 3 upcoming events
$sql = "SELECT EventName, Image, EventDate, Location 
        FROM events 
        ORDER BY EventDate DESC, EventTime DESC 
        LIMIT 3";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the data
    $events = [];
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    echo "No events available.";
}

$conn->close();
?>
    <div class="event-list container">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($event['EventName']); ?></h3>
                    <p><strong>Date:</strong> <?php echo date("F j, Y", strtotime($event['EventDate'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['Location']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </div>
    <a href="community.php" class="btn secondary-btn">See All Events</a>
</section>

<!-- Feedback Section -->
<section class="feedback-section">
    <div class="feedback-container container">
        <!-- Headline -->
        <h2>Your Feedback Matters to Us</h2>
        <!-- Subheading -->
        <p class="subheading">Help us improve! We value your input and want to hear from you about your experience with Street Hearts. Whether you’ve adopted a pet, volunteered, or just visited our site, your feedback helps us better serve street animals and our community.</p>
        <!-- Call to Action Button -->
        <a href="feedback.php" class="btn primary-btn">Share Your Feedback</a>
    </div>
</section>

<script>
    window.onload = function() {
        <?php if (isset($_SESSION['login_message'])): ?>
            showPopupAlert('<?php echo $_SESSION['login_message']; ?>', '<?php echo $_SESSION['login_message_type']; ?>');
            <?php unset($_SESSION['login_message']); ?>
        <?php endif; ?>
    };

    function showPopupAlert(message, type) {
        var popup = document.getElementById('popupAlert');
        popup.innerHTML = message;
        popup.className = 'popup-alert ' + (type === 'success' ? 'success' : 'error');
        popup.style.display = 'block';
        
        // Hide the popup after 5 seconds
        setTimeout(function() {
            popup.style.display = 'none';
        }, 5000);
    }
</script>

  <!-- Footer from partials -->
  <?php include('partials/footer_user.php'); ?>
</body>
</html>
