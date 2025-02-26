<?php
include 'db_connect.php';

// Query to fetch pet care locations including their type, description, and address
$sql = "SELECT id, name, latitude, longitude, type, description, address FROM pet_care_locations"; // Ensure your table has these columns
$result = $conn->query($sql);

$locations = [];

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $locations[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'type' => $row['type'],  // 'vet' or 'clinic'
            'description' => $row['description'],
            'address' => $row['address'] // Address field
        ];
    }
}

// Return the locations as JSON
header('Content-Type: application/json');
echo json_encode($locations);

$conn->close();
?>
