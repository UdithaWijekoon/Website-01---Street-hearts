<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Navbar</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
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

    /* Navbar Styles */
    .navbar {
      background-color: var(--primary-clr);
      color: var(--purple-white);
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    nav .container {
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo img{
      height: 62px
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
      color: var(--purple-white);
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
      background-color: var(--accent-clr);
      color: var(--purple-white);
      border: none;
      border-radius: 4px;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
    }

    .nav-links .login-button:hover {
      background-color: var(--accent-clr);
      color: var(--purple-white);
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
      background-color: var(--purple-white);
      border-radius: 3px;
      transition: 0.3s;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 1024px) {

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

  </style>
</head>
<body>
<nav class="navbar">
    <div class="container">
      <div class="logo">
        <img src="assests\sh_logo.png" alt="Street Hearts">
      </div>
      <ul class="nav-links">
        <li><a href="./index.php"><i class=""></i> Home</a></li>
        <li><a href="./about.php"><i class=""></i> About</a></li>
        <li><a href="./pet_page.php"><i class=""></i> Find Pet</a></li>
        <li><a href="./report_streetpet.php"><i class=""></i> Report Pet</a></li>
        <li><a href="./adopt_process.php"><i class=" "></i>Adopt Process</a></li>
        <li><a href="./community.php"><i class=" "></i> Community</a></li>
        <li><a href="./edu_content.php"><i class=" "></i> Educational</a></li>
        <li><a href="./shelters_and_petcarelocations.php"><i class=" "></i>Shelters</a></li>
        <li><a href="./user_profile.php"><i class="fas fa-user-circle fa-2xl"></i></a></li>
        <li><a href="user_logout.php" class="login-button btn"><i class="fa fa-sign-out"></i> Logout</a></li>
      </ul>
      <button class="hamburger" aria-label="Toggle menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
    </div>
  </nav>

  <!-- Optional: Script for toggle functionality -->
  <script>
    document.querySelector('.hamburger').addEventListener('click', () => {
      document.querySelector('.nav-links').classList.toggle('active');
    });
  </script>
</body>
</html>
