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
  <title>About Us | Street Hearts</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
   
    /* Hero Section */
    .hero-section {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    .hero-content {
      max-width: 50%;
    }

    .hero-image img {
      width: 100%;
      height: auto;
      max-width: 600px;
      border-radius: 18px;
    }

    .cta-buttons {
      gap: 24px;
      display: flex;
      margin-top: 48px;
    }

    /* Our Story Section */
    .our-story {
      display: flex;
      flex-direction: row;
    }

    .story-content {
      width: 60%;
    }

    /* Supporting Visuals */
    .visuals-gallery {
      display: flex;
      gap: 20px;
      /* margin-top: 30px; */
      width: 50%;
      flex-direction: column;
    }

    .visuals-gallery img {
      width: 100%;
      height: auto;
      max-width: 480px;
      border-radius: 8px;
    }

    /* Our Mission Section */
    .our-mission {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    .our-mission img {
      width: 600px;
      margin-left: 36px;
    }

    .mission-content {
      width: 60%;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    /* Team Grid Layout */

    .team-content {
      text-align: center;
    }
    .team-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      padding: 20px;
    }

    .team-member {
      background-color: var(--purple-white);
      padding: 15px;
      border-radius: 8px;
      text-align: center;
    }

    .team-member .role {
      font-size: 18px;
      color: var(--primary-clr);
      margin-bottom: 10px;
    }

    #team .container{
      flex-direction: column;
    }

    #partners .container{
      flex-direction: column;
    }

    #partners{
      background-color: var(--secondary-clr);
      text-align: center;
    }

    .logo-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 20px;
      padding: 0 20px;
    }

    .logo-item {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      border-radius: 8px;
    }

    .logo-item img {
      max-width: 100%;
      height: auto;
      object-fit: contain;
    }

    .contact-info {
      width: 50%;
    }

    .contact-us {
      display: flex;
    }

    /* Contact Form Styles */

    .contact-form {
      width: 50%;
      margin: 0 auto;
      padding: 40px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 16px;
      margin-bottom: 5px;
      color: var(--purple-black); 
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--purple-black);
        border-radius: 4px;
        font-size: 16px;
        color: var(--purple-black);
        background-color: var(--purple-white);
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-clr);
    }


    @media (max-width:768px){

      .hero-section {
        padding: 20px;
        display: flex;
      }

      .hero-section .container {
        flex-direction: column-reverse;
      }

      .hero-content {
        max-width: 100%;
      }

      .cta-buttons {
        gap: 12px;
        display: flex;
        margin-top: 24px;
        flex-direction: column;
        align-items: stretch;
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
    <section>
        <div class="hero-section container">
          <div class="hero-content">
            <h3>About Us</h3>
            <h1>We’re on a Mission to Save Street Pets</h1>
            <p>Every animal deserves love, care, and a home. Street Hearts is dedicated to giving street pets a second chance at life.</p>
            <div class="cta-buttons">
                <a href="pet_page.php" class="btn primary-btn">Meet Our Pets</a>
                <a href="community.php" class="btn secondary-btn">Support Our Mission</a>
            </div>
          </div>
          <div class="hero-image">
              <img src="assests/about_hero.jpg" alt="Volunteers rescuing street animals">
          </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section>
      <div class="our-story container">
        <!-- Supporting Visuals -->
        <div class="visuals-gallery">
          <img src="assests\about_ourstory1.webp" alt="Volunteers in early days">
          <img src="assests\about_ourstory2.png" alt="Volunteers rescuing animals">
        </div>

        <div class="story-content">
          <h3>Our Story</h3>
          <h2>How It All Began</h2>
          <p>
            Street Hearts was founded with a simple mission: to rescue, rehabilitate, and rehome street animals who are often overlooked and neglected. What started as a small group of passionate volunteers has grown into a thriving community dedicated to making a difference in the lives of street pets.
          </p>
          <p>
            We believe that no animal should have to live without love, care, or a safe place to call home. Through our rescue efforts, adoption programs, and community engagement, we work tirelessly to provide a better life for animals who have no voice.
          </p>
        </div>
      </div>
    </section>

    <!-- Our Mission Section -->
    <section>
      <div class="our-mission container">

        <div class="mission-content">
          <h2>Our Mission and Vision</h2>
          <p>
              At Street Hearts, our mission is to rescue street animals, provide them with the medical care and love they need, and find them permanent, loving homes. We aim to raise awareness about the plight of street pets, foster compassion, and encourage responsible pet ownership.
          </p>
          <p>
              Our vision is a world where no animal is left to fend for itself on the streets—where every pet has a family, a safe home, and a chance to live a happy life.
          </p>
          <a href="community.php" class="btn primary-btn">Join Our Mission</a>
        </div>

        <img src="assests\about_mission.jpg" alt="Mission image">

      </div>
        
    </section>

    <section id="team">
      <div class="container">
        <div class="team-content">
          <h2>The People Behind the Mission</h2>
          <p>Street Hearts wouldn’t be where it is today without the dedication and passion of our team. From our rescue workers to our adoption coordinators, each person plays a crucial role in making a difference for street pets.</p>
        </div>

        <div class="team-grid">
          <!-- Team Member 1 -->
          <div class="team-member">
            <h3>Emma Watson</h3>
            <p class="role">Founder & Director</p>
            <p>Emma’s lifelong love for animals led her to found Street Hearts. She oversees all aspects of the organization, ensuring that every pet gets the care and love they deserve.</p>
          </div>

          <!-- Team Member 2 -->
          <div class="team-member">
            <h3>John Peterson</h3>
            <p class="role">Lead Veterinarian</p>
            <p>John’s passion for animal welfare drives his work at Street Hearts, where he provides critical medical care to rescued pets.</p>
          </div>

          <!-- Team Member 3 -->
          <div class="team-member">
            <h3>Sarah Kim</h3>
            <p class="role">Adoption Coordinator</p>
            <p>Sarah ensures that every pet finds the perfect forever home by carefully matching adopters with animals in need.</p>
          </div>

          <!-- Team Member 4 -->
          <div class="team-member">
            <h3>Maria Hernandez</h3>
            <p class="role">Volunteer Coordinator</p>
            <p>Maria recruits and manages the volunteers who make our rescue operations possible, ensuring that every animal gets the love and attention they need.</p>
          </div>
        </div>

      </div>
  </section>

  <section id="partners">
    <div class="container">
      <h2>Our Supporters</h2>
      <p>We are grateful for the support of our partners, sponsors, and community members who make our mission possible. Together, we’re creating a better world for street pets.</p>

      <div class="logo-grid">
        <div class="logo-item">
          <img src="path-to-logo1.png" alt="Partner 1 Logo">
        </div>
        <div class="logo-item">
          <img src="path-to-logo2.png" alt="Partner 2 Logo">
        </div>
        <div class="logo-item">
          <img src="path-to-logo3.png" alt="Partner 3 Logo">
        </div>
        <div class="logo-item">
          <img src="path-to-logo4.png" alt="Partner 4 Logo">
        </div>
        <div class="logo-item">
          <img src="path-to-logo5.png" alt="Partner 5 Logo">
        </div>
        <div class="logo-item">
          <img src="path-to-logo6.png" alt="Partner 6 Logo">
        </div>
      </div>
      
    </div>
  </section>

  <!-- Contact Us Section -->
  <section id="contact-us">
    <div class="contact-us container">
      
      <div class="contact-info">
        <h2>Get in Touch</h2>
        <p>If you have any questions, want to get involved, or need help with a street animal, we’re here for you.</p>
        <p> <i class="fa-solid fa-location-dot" ></i>  Street Hearts, City, Country</p>
        <p> <i class="fa-solid fa-envelope " ></i> info@mywebsite.com</p>
        <p> <i class="fa-solid fa-phone " ></i> +123 456 7890</p>
      </div>

      <form id="contact-form" action="send_message_admin.php" method="POST" class="contact-form">
        <div class="form-group">
            <label for="name">Subject:</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message_content" name="message_content" rows="5" required></textarea>
        </div>
            <button type="submit" class="btn primary-btn">Send Message</button>
      </form>

    </div>
</section>

  <!-- Footer from partials -->
  <?php include('partials/footer_user.php'); ?>

<script>
document.getElementById('contact-form').addEventListener('submit', function(event) {
event.preventDefault(); // Prevent the default form submission

    // Prepare form data
    const formData = new FormData(this);

    // Send an AJAX request to the server
    fetch('send_message_admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Message sent successfully to the admin.');
            document.getElementById('contact-form').reset(); // Reset the form
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
</body>
</html>
