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
  <title>Educational</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .hero-section.container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .hero-content {
      max-width: 60%;
    }

    .edu-img {
      width: 40%;
    }

    .education-content.container {
      display: flex;
      flex-direction: column;
      max-width: 50%;
      justify-content: flex-start;
    }

    @media (max-width: 768px) {
      .hero-section {
          flex-direction: column;
          padding: 20px;
          text-align: center;
      }

      .hero-content {
          max-width: 100%;
          margin-bottom: 30px;
      }

      .hero-image img {
          width: 100%;
          height: auto;
      }

      .education-section {
          padding: 30px;
      }
    }

        .article {
            margin-bottom: 40px;
        }
        .article img {
            max-width: 300px;
            height: auto;
            margin-bottom: 10px;
        }
        .article h2 {
            color: #333;
        }
        .article p {
            text-align: justify;
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
      <h1>Learn, Care, Adopt: Your Guide to Pet Care and Adoption</h1>
      <p>Explore articles and guides designed to help you become the best pet parent and advocate for street pets. Learn how to care for your pet, understand their behavior, and navigate the adoption process.</p>
      <div class="cta-btn">
        <a href="educational.php" class="btn primary-btn">Start Learning</a>
      </div>
    </div>
    <div class="hero-image">
      <img src="assests\edu_hero.jpg" alt="Pet and owner bonding">
    </div>
  </div>
</section>

<!-- Why Education Matters Section -->
<section class="education-section">
  <div class="education container">
    <div class="edu-img">
      <img src="assests\edu_2.jpg" alt="edu-img">
    </div>
    <div class="education-content container">
        <h2>Why Pet Education is Important</h2>
        <p>Adopting a pet is a lifelong commitment, and understanding their needs is crucial to ensuring their well-being. At Street Hearts, we believe that education is key to a successful adoption and a happy pet. Whether you're a first-time pet owner or looking to learn more, our resources will help you become a confident, informed pet parent.</p>
    </div>
  </div>
</section>


  <!-- Footer from partials -->
  <?php include('partials/footer_user.php'); ?>

</body>
</html>