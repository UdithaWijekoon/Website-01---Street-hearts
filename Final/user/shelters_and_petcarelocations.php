<?php

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
    <title>Shelters and Pet Care Locations</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>

      /* Hero Section */
      .hero-section {
        background-color: var(--purple-white);
      }

      .hero {
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
      }

      /* Shelter Help Section */
      .shelter-help {
        display: flex;
        text-align: left;
      }

      .help-content{
        width: 50%;
      }

      /* Form Section */
    .contact-shelter form {
      background-color: var(--purple-white);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-shelter form label {
      display: block;
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .contact-shelter form select, form input[type="text"], form textarea {
      width: 96%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid var(--primary-clr);
      border-radius: 5px;
      font-size: 16px;
    }

    form textarea {
      height: 150px;
      resize: none;
    }

    .help-img {
      width: 50%;
    }


    /* Pet Care Locations Section */
    #map {
      height: 600px;
      width: 100%;
      margin-top: 50px;
    }

    .locations-description {
      margin-top: 30px;
      padding: 20px;
      width: 50%;
    }
    .marker-description {
      text-align: center;
      font-size: 16px;
      color: #555;
    }

  </style>
</head>
<body>

<?php
//header from partials
include('partials/header_user.php');
?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero container">
            <h1>You Can Contact a Shelter or Find Pet Care Locations near You to Save a Life</h1>
            <p>Contact animal shelters and find pet care locations near you to help street pets get the care they need.</p>
            <a href="#map" class="btn primary-btn">Find Nearby Pet Care Locations</a>
        </div>
    </section>

    <!-- How Animal Shelters Help Section -->
    <section class="contact-shelter">
        <div class="shelter-help container">
            <div class="help-content">
              <h2>How Animal Shelters Help Street Pets</h2>
              <p>
                Animal shelters play a crucial role in rescuing, rehabilitating, and rehoming street pets.
                At Street Hearts, we partner with local shelters to provide a safe haven for animals in need. You can contact a shelter here.
              </p>
        </div>

          <form action="send_message_shelter.php" method="POST">
          <label for="shelter">Select Shelter:</label>
          <select id="shelter" name="shelter_id" required>
              <?php
              // Fetch shelters from the database
              include 'db_connect.php';
              $result = $conn->query("SELECT ShelterID, ShelterName FROM shelters");
      
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['ShelterID'] . "'>" . $row['ShelterName'] . "</option>";
              }
              ?>
          </select>
      
          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" required>
          
          <label for="message">Your Message:</label>
          <textarea id="message" name="message_content" required></textarea>
          
          <button type="submit" class="btn primary-btn">Send Message to Shelter</button>
      </form>
    </section>

  <!-- Pet Care Locations Section -->
  <section>
    <div class="container">
      <div class="help-img">
        <img src="assests\petcare.jpg" alt="Street Pet Shelter">
      </div>

      <div class="locations-description">
        <h2>Find Pet Care Locations Near You</h2>
        <p>
          Discover veterinary services and pet clinics in your area. We’ve mapped out the best places to care for your pet, 
          including vets for emergency medical attention and clinics for regular check-ups. After clicking on markers of Vet centers or Pet clinics on the map, You can open the location in Google maps. 
        </p>
      </div>

    </div>
        <!-- Marker Description -->
        <div class="marker-description">
        <p><strong style="color: red;">Red markers</strong> are for vet centers, and <strong style="color: blue;">Blue markers</strong> are for pet clinics.</p>
        </div>

        <div id="map"></div>
    </section>

    <!-- Footer from partials -->
    <?php include('partials/footer_user.php'); ?>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([7.8731, 80.7718], 8); // Center on Sri Lanka

        // Set up the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Define custom icons for vet centers (red) and pet clinics (blue)
        const vetIcon = L.icon({
            iconUrl: 'https://img.icons8.com/?size=100&id=KTgnvbyxA9Mz&format=png&color=ff0000', // Red for vet
            iconSize: [50, 50],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        const clinicIcon = L.icon({
            iconUrl: 'https://img.icons8.com/?size=100&id=aTmbXri3SX26&format=png&color=0000ff', // Blue for clinics
            iconSize: [50, 50],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        // Function to add a marker with the appropriate icon based on type
        function addMarker(lat, lng, name, type, description, address) {
            const icon = type === 'vet' ? vetIcon : clinicIcon; // Choose icon based on type

            const marker = L.marker([lat, lng], { icon }).addTo(map);

            // Bind a popup to the marker with location details including address
            marker.bindPopup(`<b>${name}</b><br>${description}<br>${address}<br>
                <button onclick="openInGoogleMaps(${lat}, ${lng})">Open in Google Maps</button>`);
        }

        // Fetch locations from the database
        fetch('get_locations.php')
            .then(response => response.json())
            .then(locations => {
                locations.forEach(location => {
                    addMarker(location.latitude, location.longitude, location.name, location.type, location.description, location.address);
                });
            });

        // Function to open location in Google Maps
        function openInGoogleMaps(lat, lng) {
            window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
        }
    </script>
</body>
</html>
