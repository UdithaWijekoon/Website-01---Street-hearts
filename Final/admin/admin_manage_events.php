<?php
// admin_manage_events.php
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

// Initialize message variables
$successMessage = $errorMessage = '';

// Handle form submission for adding or updating an event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    try {
        $eventName = $_POST['event_name'];
        $eventDescription = $_POST['event_description'];
        $eventDate = $_POST['event_date'];
        $eventTime = $_POST['event_time'];
        $location = $_POST['location'];
        $adminID = $_SESSION['admin_id']; // Assuming admin_id is stored in session

        // Handle file upload (image)
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = '../uploads/events/' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                throw new Exception("Failed to upload image.");
            }
        } else {
            $imagePath = null; // No image uploaded
        }

        // Insert new event
        if (empty($_POST['event_id'])) {
            $sql = "INSERT INTO events (EventName, EventDescription, EventDate, EventTime, Location, CreatedByAdmin, Image) 
                    VALUES (:EventName, :EventDescription, :EventDate, :EventTime, :Location, :CreatedByAdmin, :Image)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'EventName' => $eventName,
                'EventDescription' => $eventDescription,
                'EventDate' => $eventDate,
                'EventTime' => $eventTime,
                'Location' => $location,
                'CreatedByAdmin' => $adminID,
                'Image' => $imagePath,
            ]);
            $_SESSION['success'] = "Event added successfully!";
        } else {
            // Update existing event
            $eventID = $_POST['event_id'];
            $sql = "UPDATE events 
                    SET EventName = :EventName, EventDescription = :EventDescription, EventDate = :EventDate, 
                        EventTime = :EventTime, Location = :Location, Image = :Image 
                    WHERE EventID = :EventID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'EventName' => $eventName,
                'EventDescription' => $eventDescription,
                'EventDate' => $eventDate,
                'EventTime' => $eventTime,
                'Location' => $location,
                'Image' => $imagePath,
                'EventID' => $eventID,
            ]);
            $_SESSION['success'] = "Event updated successfully!";
        }

        // Redirect to the events page to prevent resubmission and display message
        header("Location: admin_manage_events.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: admin_manage_events.php");
        exit();
    }
}

// Handle form submission for deleting an event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    try {
        $eventID = $_POST['event_id'];
        
        // Delete event from the database
        $sqlDelete = "DELETE FROM events WHERE EventID = :EventID";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute(['EventID' => $eventID]);

        $_SESSION['success'] = "Event deleted successfully!";
        // Redirect to avoid form resubmission
        header("Location: admin_manage_events.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: admin_manage_events.php");
        exit();
    }
}

//header from partials
include('partials/header_admin.php');

// Fetch all events
$sql = "SELECT * FROM events";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve and clear messages from session
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <style>
        /* Add CSS for success and error messages */
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .error-message {
            color: #e74c3c;
            background-color: #f8d7da;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        /* Existing CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }

        .form2 {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #34495e;
        }

        input[type="text"], input[type="date"], input[type="time"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        .btn2 {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn2:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4C4D4C;
            color: white;
        }

        td img {
            border-radius: 8px;
        }

        td form {
            display: inline;
        }

        button[name="action"][value="delete"] {
            background-color: #e74c3c;
        }

        button[name="action"][value="delete"]:hover {
            background-color: #c0392b;
        }

        @media (max-width: 768px) {
            form {
                padding: 15px;
            }

            input[type="text"], input[type="date"], input[type="time"], textarea, input[type="file"] {
                font-size: 14px;
            }

            button {
                font-size: 14px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<h1><i class="fa fa-calendar" aria-hidden="true"></i> Manage Events</h1>

<!-- Display success or error messages -->
<?php if ($successMessage): ?>
    <div class="success-message">
        <?php echo htmlspecialchars($successMessage); ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="error-message">
        <?php echo htmlspecialchars($errorMessage); ?>
    </div>
<?php endif; ?>

<!-- Form to add or edit event -->
<form class="form2" action="admin_manage_events.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="event_id" value="<?php echo isset($event['EventID']) ? $event['EventID'] : ''; ?>">
    <input type="hidden" name="action" value="save">
    <label for="event_name">Event Name:</label>
    <input type="text" name="event_name" id="event_name" required><br>

    <label for="event_description">Description:</label>
    <textarea name="event_description" id="event_description" required></textarea><br>

    <label for="event_date">Date:</label>
    <input type="date" name="event_date" id="event_date" required><br>

    <label for="event_time">Time:</label>
    <input type="time" name="event_time" id="event_time" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required><br>

    <label for="image">Event Image:</label>
    <input type="file" name="image" id="image"><br>

    <button class="btn2" type="submit">Save Event</button>
</form>


<!-- List of events -->
<h2>Existing Events</h2>
<table border="1">
    <tr>
        <th>Event ID</th>
        <th>Event Name</th>
        <th>Event Description</th>
        <th>Event Date</th>
        <th>Event Time</th>
        <th>Location</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo htmlspecialchars($event['EventID']); ?></td>
            <td><?php echo htmlspecialchars($event['EventName']); ?></td>
            <td><?php echo htmlspecialchars($event['EventDescription']); ?></td>
            <td><?php echo htmlspecialchars($event['EventDate']); ?></td>
            <td><?php echo htmlspecialchars($event['EventTime']); ?></td>
            <td><?php echo htmlspecialchars($event['Location']); ?></td>
            <td><img src="<?php echo htmlspecialchars($event['Image']); ?>" alt="Event Image" width="100"></td>
            <td>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                    <input type="hidden" name="event_id" value="<?php echo $event['EventID']; ?>">
                    <button class="btn2" type="submit" name="action" value="delete">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
