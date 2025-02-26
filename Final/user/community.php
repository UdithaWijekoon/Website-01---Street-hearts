<?php
include 'db.php';
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
  <title>Community</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/style.css">
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
    }

    section{
      padding: 36px 0;
    }


    .container {
      display: flex;
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
      padding: 20px;
      flex-direction: row;
      justify-content: space-around;
    }


    /* buttons */

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

    .cta-btn{
      margin-top: 36px;
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
      margin: 24px 0;
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


    @media (max-width:768px) {
      body {
        text-align: center;
        font-size: 16px;
      }

      .container{
        flex-direction: column;
      }

      h1 {
        font-size: 32px;
        line-height: 36px;
        margin: 12px;
      }

      h2 {
        font-size: 18px;
        margin-bottom: 16px;
      }

      h3 {
        font-size: 14px;
        margin-bottom: 10px;
      }

      p{
        font-size: 12px;
        margin: 12px;
      }

      .btn {
        padding: 8px 16px;
        border: solid 1px var(--primary-clr);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
      }

    }



    /* Hero Section */

    .hero-image {
      max-width: 40%;
      height: auto;
      border-radius: 10px;
      margin-left: 36px;
    }

    /* Success Stories Section */
    .success-stories {
      display: flex;
      flex-direction: column;
      text-align: center;
    }

    .stories-slider {
      display: flex;
      overflow-x: scroll;
      scroll-behavior: smooth;
      gap: 24px;
      padding: 20px;
    }

    .story-card {
      background-color: var(--purple-white);
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      min-width: 300px;
      max-width: 350px;
    }

    /* AdoptedStory Section */
    .adopt-content {
      text-align: center;
    }

    /* Adopted pets section */
    .container-pets {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      max-width: 1200px;
    }

    .pet-card {
      border: 2px solid var(--secondary-clr);
      border-radius: 8px;
      padding: 18px;
      width: 250px;
      background-color: var(--purple-white);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .pet-card img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    /* Event Section */
    .events{
      text-align: center;
      flex-direction: column;
    }

    .event-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1rem;
      max-width: 1200px;
    }

    .event-item {
      display: flex;
      background-color: var(--purple-white);
      border: 2px solid var(--secondary-clr);
      padding: 18px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
      align-items: center;
      flex-direction: column;
    }
    
    /* Volunteer Form */
    .volunteer-form {
      display: flex;
      flex-direction: column;
    }

    .horizontal-form {
      max-width: 900px;
      margin: 36px auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-end;
    }

    .form-row {
      width: 48%; 
      margin-bottom: 20px;
    }

    .form-row label {
      flex: 1;
      margin-right: 10px;
      text-align: right; 
    }

    .form-row input, 
    .form-row textarea {
      flex: 2;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 100%;
    }

    textarea {
      resize: vertical;
    }

    .btn-submit {
      padding: 10px 20px;
      cursor: pointer;
      width: 100%;
    }

    @media screen and (max-width: 768px) {
      .form-row {
        width: 100%; 
      }
    }

    /* Donate Form */
    .donate-content {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      width: 60%;
      padding-right: 36px;
    }

    .donate-us form {
      background-color: var(--secondary-clr);
      display: flex;
      flex-direction: column;
      gap: 8px;
      width: 40%;
      margin: auto;
      padding: 24px;
      border-radius: 8px;
    }

    .donate-us label {
        font-weight: bold;
    }

    .donate-us input {
      padding: 10px;
      border: 2px solid var(--primary-clr);
      border-radius: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .hero-section {
        flex-direction: column;
        text-align: center;
      }

      .hero-image {
        max-width: 100%;
        margin-top: 1rem;
      }

      .stories-slider {
        overflow-x: scroll;
      }
    }

/* Popup container */
#successPopup {
    display: none; /* Hidden by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 30px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    z-index: 1000;
    text-align: center;
    border: 1px solid #ccc;
}

/* Popup text */
#successPopup p {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
}

/* Close button */
#successPopup button {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#successPopup button:hover {
    background-color: #218838;
}

/* Add slight fade-in animation */
@keyframes popupFadeIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

/* Apply animation */
#successPopup {
    animation: popupFadeIn 0.3s ease;
}

/* Darken the background when popup appears */
body.popup-active::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 999;
}


  </style>
</head>
<body>

<?php
//header from partials
include('partials/header_user.php');
?>
  <!-- Hero Section -->
<section>
  <div class="container">
    <div class="hero-content">
      <h1>Join the Street Hearts Community!</h1>
      <p class="subheading">Celebrate success stories, discover volunteer opportunities, and participate in events that make a difference in the lives of street pets. Your involvement matters.</p>
      <div class="cta-btn">
        <a href="#volunteer" class="btn primary-btn">Get Involved Today</a>
      </div>
    </div>
    <img src="assests\community_hero.png" alt="Volunteers with pets" class="hero-image">
  </div>
</section>
<?php
// Fetch success stories from the database for the slider
$sql = "SELECT ss.Title, ss.Story, ss.Date, p.PetName
        FROM success_stories ss
        LEFT JOIN pets p ON ss.PetID = p.PetID
        ORDER BY ss.Date DESC LIMIT 5"; // Fetch latest 5 success stories for the slider
$stmt = $pdo->query($sql);
$stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="success-stories">
  <div class="success-stories container">
    <h2>Success Stories</h2>
    <p>Meet the heroes behind every adoption story—families and individuals who opened their hearts to street pets. Browse through inspiring stories of love, transformation, and new beginnings. Share your own adoption journey to inspire others!</p>
    <div class="stories-slider container">
      <?php foreach ($stories as $story): ?>
        <div class="story-card">
          <h3><?php echo htmlspecialchars($story['Title']); ?></h3>
          <p><strong>Pet Name: </strong><?php echo htmlspecialchars($story['PetName'] ?? 'Unknown Pet'); ?></p>
          <p><?php echo nl2br(htmlspecialchars($story['Story'])); ?></p>
          <div class="story-date">
            <p><?php echo date("F j, Y", strtotime($story['Date'])); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="adopted-pets" id="adopted-pets">
  <div class="adopt-content">
    <h2>Adopted Pets</h2>
    <p>Every pet deserves a loving home, and thanks to our incredible community, these street pets have found theirs.</p>
  </div>
<?php
try {
    // Query to select all adopted pets
    $sql = "SELECT * FROM pets WHERE Status = 'Adopted'";
    $stmt = $pdo->query($sql);

    // Fetch all adopted pets
    $adopted_pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching adopted pets: " . $e->getMessage();
}
?>
<div class="container-pets container">
    <?php if (!empty($adopted_pets)): ?>
        <?php foreach ($adopted_pets as $pet): ?>
            <div class="pet-card">
                <img src="../uploads/pet_profiles/<?php echo htmlspecialchars($pet['ProfilePicture']); ?>" alt="<?php echo htmlspecialchars($pet['PetName']); ?>">
                <h3><?php echo htmlspecialchars($pet['PetName']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($pet['PetType']); ?></p>
                <p>Breed: <?php echo htmlspecialchars($pet['Breed']); ?></p>
                <p>Age: <?php echo htmlspecialchars($pet['Age']); ?> years</p>
                <p>Gender: <?php echo htmlspecialchars($pet['Gender']); ?></p>
                <p>Status: <?php echo htmlspecialchars($pet['HealthStatus']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No pets have been adopted yet.</p>
    <?php endif; ?>
</div>
</section>

<?php
// Fetch upcoming events
$sql = "SELECT * FROM events WHERE EventDate >= CURDATE() ORDER BY EventDate";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section >
  <div class="events container">
    <h2>Upcoming Events</h2>
    <p>Be part of our exciting events! From adoption days to community fundraising, these events are a great way to get involved, meet fellow animal lovers, and support the Street Hearts mission.</p>
  </div>
  <div class="container">
    <?php if (!empty($events)): ?>
      <div class="event-list">
        <?php foreach ($events as $event): ?>
        <div class="event-item">
          <h3><?php echo htmlspecialchars($event['EventName']); ?></h3>
          <p><?php echo htmlspecialchars($event['EventDescription']); ?></p>
          <p><strong>Date:</strong> <?php echo htmlspecialchars($event['EventDate']); ?></p>
          <p><strong>Time:</strong> <?php echo htmlspecialchars($event['EventTime']); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($event['Location']); ?></p>
          <?php if (!empty($event['Image'])): ?>
            <img src="<?php echo htmlspecialchars($event['Image']); ?>" alt="Event Image" width="200">
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>No upcoming events.</p>
    <?php endif; ?>
  </div>
</section>

<section id="volunteer">
  <div class="volunteer-form container">
    <h2>Become a Volunteer</h2>
    <form action="submit_volunteer.php" method="POST" class="horizontal-form">
      <div class="form-row">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>
      </div>

      <div class="form-row">
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>
      </div>

      <div class="form-row">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-row">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone">
      </div>
      
      <div class="form-row">
        <label for="address">Address:</label>
        <textarea id="address" name="address"></textarea>
      </div>

      <div class="form-row">
        <label for="reason">Reason for Volunteering:</label>
        <textarea id="reason" name="reason" required></textarea>
      </div>

      <div class="form-row">
        <label for="skills">Skills:</label>
        <textarea id="skills" name="skills"></textarea>
      </div>

      <div class="form-row">
        <button type="submit" class="btn primary-btn btn-submit">Submit</button>
      </div>
    </form>
  </div>
</section>

<?php
$userID = $_SESSION['UserID'] ?? null; 
$donationSuccess = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donatorName = $_POST['donatorName'];
    $donationAmount = $_POST['donationAmount'];
    $receipt = $_FILES['paymentReceipt']['name'];
    $target_dir = "../uploads/donations/";
    $target_file = $target_dir . basename($receipt);
    move_uploaded_file($_FILES['paymentReceipt']['tmp_name'], $target_file);

    try {
      $sql = "INSERT INTO donations (UserID, DonatorName, DonationAmount, PaymentReceipt) 
              VALUES (:UserID, :DonatorName, :DonationAmount, :PaymentReceipt)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
          ':UserID' => $userID,
          ':DonatorName' => $donatorName,
          ':DonationAmount' => $donationAmount,
          ':PaymentReceipt' => $target_file
      ]);
      
      // Set success flag
      $donationSuccess = true;

  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
?>

  <section class="donate-us" id="donate">
    <div class="container">
      <div class="donate-content">
        <h2>Make a Difference Today</h2>
        <p>Your generosity helps us rescue, care for, and find loving homes for street pets in need. Every contribution, big or small, goes a long way in saving lives.</p>
        <p>Thank you for choosing to support Street Hearts. Complete the form below to make your secure donation. Your gift will directly impact the lives of street animals, helping to provide food, shelter, medical care, and adoption services.</p>
      </div>
      <form action="community.php#donate" method="POST" enctype="multipart/form-data">
        <h2>Donate Us</h2>
        <label for="donatorName">Your Name:</label>
        <input type="text" id="donatorName" name="donatorName" required><br>

        <label for="donationAmount">Donation Amount:</label>
        <input type="number" id="donationAmount" name="donationAmount" step="0.01" required><br>

        <label for="paymentReceipt">Upload Payment Receipt:</label>
        <input type="file" id="paymentReceipt" name="paymentReceipt" accept="image/*,application/pdf" required><br>

        <button type="submit" class="btn primary-btn">Donate</button>
      </form>
    </div>
  </section>

  <!-- Success Popup -->
<div id="successPopup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border: 2px solid #000; padding: 20px; z-index: 1000;">
    <p>Your donation information was successfully submitted to the admin panel!</p>
    <button onclick="closePopup()">Close</button>
</div>

  <!-- Footer from partials -->
  <?php include('partials/footer_user.php'); ?>

<script>
// Function to display the popup
function showPopup() {
    document.getElementById('successPopup').style.display = 'block';
}

// Function to close the popup
function closePopup() {
    document.getElementById('successPopup').style.display = 'none';
}

// Check if donation was successful and show popup
<?php if ($donationSuccess): ?>
    window.onload = function() {
        showPopup();
    };
<?php endif; ?>
</script>


</body>
</html>