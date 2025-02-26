<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}
//header from partials
include('partials/header_admin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Pet Care Location</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f7f8fa;
    margin: 0;
    padding: 20px;
    color: #333;
}

h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
}

.form2 {
    max-width: 1000px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

.btn2[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4A90E2;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

.btn2[type="submit"]:hover {
    background-color: #357ABD;
}

/* Map Styles */
#map {
    height: 800px;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

/* Responsive Styles */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }

    button[type="submit"] {
        font-size: 14px;
        padding: 10px;
    }
}

    </style>
</head>
<body>
    <h2><i class="fa fa-thumb-tack" aria-hidden="true"></i> Add Pet Care Location</h2>
    <form class="form2" action="submit_location.php" method="POST">
        <label for="name">Location Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="district">District:</label><br>
        <input type="text" id="district" name="district" required><br>

        <label for="type">Type:</label><br>
        <select id="type" name="type" required>
            <option value="vet">Vet</option>
            <option value="clinic">Pet Clinic</option>
        </select><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br>

        <label for="map">Select Location on Map:</label>
        <div id="map"></div>

        <label for="latitude">Latitude:</label><br>
        <input type="text" id="latitude" name="latitude" required readonly><br>

        <label for="longitude">Longitude:</label><br>
        <input type="text" id="longitude" name="longitude" required readonly><br>

        <button class="btn2" type="submit">Add Location</button>
    </form>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([7.8731, 80.7718], 8); // Center on Sri Lanka

        // Set up the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Initialize a marker
        let marker;

        // Event listener to set marker and coordinates on map click
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;

            // If a marker exists, remove it
            if (marker) {
                map.removeLayer(marker);
            }

            // Add a new marker at the clicked location
            marker = L.marker([lat, lng]).addTo(map);

            // Set the latitude and longitude values in the form
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    </script>

    <!-- Footer from partials -->
    <?php include('partials/footer_admin.php'); ?>
</body>
</html>
