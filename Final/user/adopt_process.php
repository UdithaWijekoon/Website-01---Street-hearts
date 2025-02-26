<?php
include 'db.php';

session_start();

//Check if the user is logged in
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
    <title>Adoption Process</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
      
      /* Hero Section */
      .hero {
        background-color: var(--purple-white);
        text-align: center;
      }

      .hero .container{
        flex-direction: column;
      }

      /* Adoption Process Section */
      .adoption-process {
        background-color: #fff;
        padding: 50px 0;
        text-align: center;
      }

      .adoption-process .container{
        flex-direction: column;
      }

      .steps-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        margin-top: 40px;
      }

      .step {
        background-color: var(--secondary-clr);
        padding: 30px;
        border-radius: 10px;
        text-align: left;
      }

      /* Why Choose Us Section */
      .why-choose-us{
        background-color: var(--purple-white);
      }
      .why-choose-us .container {
        flex-direction: column;
        text-align: center;
      }

      /* Ready to Adopt Section */
      .ready-to-adopt .container{
        flex-direction: column;
        text-align: center;
      }



      @media (max-width: 768px) {
        .steps-grid {
            grid-template-columns: 1fr;
        }

        .container {
            width: 95%;
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
    <section class="hero">
        <div class="container">
            <h1>Your Journey to a New Best Friend Starts Here</h1>
            <p>Learn how our simple and thorough adoption process ensures the best match for both pets and adopters.</p>
        </div>
    </section>

    <!-- Adoption Process Section -->
    <section class="adoption-process">
        <div class="container">
            <h2>How Our Adoption Process Works</h2>
            <p>At Street Hearts, our goal is to ensure that every adoption is a perfect match—for the pet and the family. Follow these steps to find your new companion.</p>

            <div class="steps-grid">
                <!-- Step 1 -->
                <div class="step">
                    <h3>Step 1: Search and Choose Your Pet</h3>
                    <p>Explore our list of available pets on our Pet Search page and use the filter options to find a pet that matches your preferences. Each pet has a detailed profile that includes their history, health status, and temperament.</p>
                </div>

                <div>
                  <img src="assests\step_1.jpg" alt="step 1 img">
                </div>

                <!-- Step 2 -->

                <div>
                  <img src="assests\step_2.jpg" alt="step 2 img">
                </div>
   
                <div class="step">
                    <h3>Step 2: Submit an Adoption Application</h3>
                    <p>Once you've found a pet you're interested in, click on their profile and submit an adoption application. You'll be asked to provide information about your living situation, experience with pets, and preferences for the type of pet you're looking to adopt.</p>
                </div>

                <!-- Step 3 -->
                <div class="step">
                    <h3>Step 3: Meet & Greet</h3>
                    <p>After reviewing your application, our team will arrange a meet-and-greet with the pet either at our shelter or through a home visit. This allows you to spend time with the pet and ensure a mutual connection.</p>
                </div>

                <div>
                  <img src="assests\step_3.jpg" alt="step 3 img">
                </div>

                <!-- Step 4 -->
                <div>
                  <img src="assests\step_4.jpg" alt="step 4 img">
                </div>

                <div class="step">
                    <h3>Step 4: Home Check</h3>
                    <p>To make sure the environment is safe and suitable for the pet, we may conduct a brief home visit. This step is crucial to ensure the pet's well-being in its new surroundings.</p>
                </div>

                <!-- Step 5 -->
                <div class="step">
                    <h3>Step 5: Final Approval</h3>
                    <p>If the meet-and-greet and home check go well, we will approve your adoption! At this point, we'll discuss any final details, such as the adoption fee and any documents you need to sign.</p>
                </div>
                <div>
                  <img src="assests\step_5.png" alt="step 5 img">
                </div>

                <!-- Step 6 -->
                <div>
                  <img src="assests\step_6.png" alt="step 6 img">
                </div>
                <div class="step">
                    <h3>Step 6: Bring Your Pet Home</h3>
                    <p>Once everything is finalized, it's time to bring your new companion home! We'll provide you with all the information you need to help your pet transition smoothly into your family.</p>
                    <div class="cta-btn">
                      <a href="edu_content.php" class="btn primary-btn">View Pet Care Tips</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container">
            <h2>Why Choose Street Hearts?</h2>
            <p>When you adopt from Street Hearts, you're giving a street pet a second chance at life. We rescue animals from the streets, provide them with medical care, and prepare them for adoption. By adopting from us, you're not just gaining a pet—you’re helping save a life and supporting our mission to reduce the street pet population.</p>
            <div class="cta-btn">
              <a href="about.php" class="btn primary-btn">Learn More About Our Mission</a>
            </div>
        </div>
    </section>

    <!-- Ready to Adopt Section -->
    <section class="ready-to-adopt">
        <div class="container">
            <h2>Ready to Adopt?</h2>
            <p>Your perfect companion is waiting for you. Start your adoption journey today and give a street pet a loving home.</p>
            <div class="cta-btn">
              <a href="pet_page.php" class="btn secondary-btn">Start Your Search</a>
            </div>
        </div>
    </section>

  <!-- Footer from partials -->
  <?php include('partials/footer_user.php'); ?>
</body>
</html>
