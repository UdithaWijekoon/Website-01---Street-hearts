<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Section</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
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
      font-family: 'Open Sans', sans-serif;
    }

    footer {
      background-color: var(--accent-clr);
      color: var(--secondary-clr);
      padding: 40px 20px;
      font-size: 16px;
    }

    .footer .container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .footer .container{
      align-items: flex-start;
    }

    .footer-section {
      flex: 1;
      padding: 20px;
    }

    .footer-section h4 {
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      font-size: 20px;
      margin-bottom: 15px;
    }

    .footer-section p {
      color: var(--purple-white);
    }

    .logo a {
      font-family: 'Montserrat', sans-serif;
      font-size: 24px;
      font-weight: 600;
      color: var(--purple-white);
      text-decoration: none;
      display: block;
      margin-bottom: 10px;
    }

    .logo img{
      width: 120px;
      height: auto;
    }

    .subscribe-form {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .subscribe-form input[type="email"] {
      padding: 10px;
      flex: 1;
      border: none;
      border-radius: 4px;
    }

    .subscribe-form button {
      padding: 10px 20px;
      background-color: var(--purple-black);
      color: var(--purple-white);
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .subscribe-form button:hover {
      background-color: var(--primary-clr);
    }

    .quick-links ul {
      list-style: none;
      padding-right: 20px;
      padding-left: 0px;
      margin: 0;
    }

    .quick-links ul li {
      margin-bottom: 10px;
    }

    .quick-links ul li a {
      color: var(--purple-white);
      text-decoration: none;
    }

    .quick-links ul li a:hover {
      color: var(--secondary-clr);
    }

    .links {
      display: flex;
      justify-content: space-between;
    }

    .contact-details p {
      margin: 18px 0;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 10px;
    }

    .social-icons a img {
      width: 24px;
      height: 24px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        display: flow;
        text-align: center;
        padding: 0;
      }

      .footer-section {
        padding: 10px;
      }

      .links {
        display: flex;
        flex-direction: column;
        padding-right: 0px;
      }

      .subscribe-form {
        flex-direction: column;
      }

      .subscribe-form input[type="email"], 
      .subscribe-form button {
        width: 100%;
      }
    }

    .social-icons a {
      color: var(--purple-white); 
      font-size: 24px;
      margin-right: 15px; 
      text-decoration: none;
    }

    .social-icons a:hover {
      color: var(--secondary-clr);
    }

</style>
</head>
<body>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <!-- Logo & Subscribe Section -->
      <div class="footer-section logo-subscribe">
        <div class="logo">
          <img src="assests\sh_logo.png" alt="">
        </div>
        <p>Join us in our mission to provide shelter, care, and love to every street animal.</p>
        <h4>Join Our Commuinty</h4>
        <p>Sign up to receive the latest updates, success stories, and upcoming events from Street Hearts.</p>
      </div>

      <!-- Quick Links Section -->
      <div class="footer-section quick-links">
        <h4>Quick Links</h4>
        <div class="links">
          <ul>
            <li><a href="./index.php"><i class=""></i> Home</a></li>
            <li><a href="./about.php"><i class=""></i> About</a></li>
            <li><a href="./pet_page.php"><i class=""></i> Find Pet</a></li>
            <li><a href="./report_streetpet.php"><i class=""></i> Report Pet</a></li>
            <li><a href="./adopt_process.php"><i class=" "></i>Adopt Process</a></li>
            <li><a href="./community.php"><i class=" "></i> Community</a></li>
            <li><a href="./edu_content.php"><i class=" "></i> Educational</a></li>
            <li><a href="./shelters_and_petcarelocations.php"><i class=" "></i>Shelters</a></li>
            <li><a href="./feedback.php"><i class=" "></i>Feedback</a></li>
          </ul>
          <ul>
            <li><a href="./user_terms_conditions.php">Terms & Conditions</a></li>
          </ul>
        </div>
      </div>

      <!-- Contact Details Section -->
      <div class="footer-section contact-details">
        <h4>Contact Us</h4>
        <p> <i class="fa-solid fa-location-dot" style="color: #F5EFFF ;"></i>  Street Hearts, City, Country</p>
        <p> <i class="fa-solid fa-envelope " style="color: #F5EFFF;"></i> info@mywebsite.com</p>
        <p><i class="fa-solid fa-phone " style="color: #F5EFFF;"></i> +123 456 7890</p>
        <div class="social-icons">
          <a href="#" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i> <!-- Font Awesome Facebook Icon -->
          </a>
          <a href="#" aria-label="Instagram">
            <i class="fab fa-instagram"></i> <!-- Font Awesome Instagram Icon -->
          </a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
