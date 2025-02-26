<?php
include 'db.php';

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Function to set success or error messages
function set_message($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

// Handle adding new content
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $adminID = $_SESSION['admin_id'];

    // Handle image upload
    $imageURL = null;
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . $_FILES['image']['name']; // Unique image name
        $imagePath = '../uploads/content/' . $imageName; // Folder for storing images
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $imageURL = $imagePath;
        } else {
            set_message('Failed to upload image.', 'error');
        }
    }

    // If there's no error, insert the content
    $sql = "INSERT INTO educational_content (Category, Title, Content, ImageURL, AdminID) 
            VALUES (:category, :title, :content, :imageURL, :adminID)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        'category' => $category,
        'title' => $title,
        'content' => $content,
        'imageURL' => $imageURL,
        'adminID' => $adminID
    ])) {
        set_message('Content added successfully.');
    } else {
        set_message('Failed to add content.', 'error');
    }

    header("Location: admin_manage_content.php");
    exit();
}

// Handle editing content
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $contentID = $_POST['content_id'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . $_FILES['image']['name'];
        $imagePath = 'uploads/' . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $sql = "UPDATE educational_content SET Category = :category, Title = :title, Content = :content, ImageURL = :imageURL 
                    WHERE ContentID = :contentID";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'category' => $category,
                'title' => $title,
                'content' => $content,
                'imageURL' => $imagePath,
                'contentID' => $contentID
            ]);
            set_message('Content updated successfully.');
        } else {
            set_message('Failed to upload new image.', 'error');
        }
    } else {
        // If no new image is uploaded, keep the existing image
        $sql = "UPDATE educational_content SET Category = :category, Title = :title, Content = :content 
                WHERE ContentID = :contentID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'category' => $category,
            'title' => $title,
            'content' => $content,
            'contentID' => $contentID
        ]);
        set_message('Content updated successfully.');
    }

    header("Location: admin_manage_content.php");
    exit();
}

// Handle deleting content
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $contentID = $_POST['content_id'];
    
    // Delete the content
    $sql = "DELETE FROM educational_content WHERE ContentID = :contentID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['contentID' => $contentID]);

    set_message('Content deleted successfully.');
    header("Location: admin_manage_content.php");
    exit();
}

// Fetch all content to manage
$sql = "SELECT * FROM educational_content ORDER BY DatePosted DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

//header from partials
include('partials/header_admin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Educational Content</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        h2 {
            color: #34495e;
            margin-bottom: 10px;
        }

        .form2 {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], textarea, select, input[type="file"] {
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
            margin-right: 10px;
        }

        .btn2:hover {
            background-color: #218838;
        }

        .btn2[name="action"][value="delete"] {
            background-color: #e74c3c;
        }

        .btn2[name="action"][value="delete"]:hover {
            background-color: #c0392b;
        }

        img {
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .success-message {
            color: #2ecc71;
            background-color: #e9f7ef;
            padding: 10px;
            border: 1px solid #2ecc71;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error-message {
            color: #e74c3c;
            background-color: #f9ebea;
            padding: 10px;
            border: 1px solid #e74c3c;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            form {
                padding: 15px;
            }

            input[type="text"], textarea, select, input[type="file"] {
                font-size: 14px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<h1><i class="fa fa-book" aria-hidden="true"></i> Manage Educational Content</h1>

<!-- Display success or error message -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="<?php echo $_SESSION['message_type'] === 'error' ? 'error-message' : 'success-message'; ?>">
        <?php echo $_SESSION['message']; ?>
        <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php unset($_SESSION['message_type']); ?>
    </div>
<?php endif; ?>

<!-- Add New Content -->
<h2>Add New Content</h2>
<form class="form2" method="POST" enctype="multipart/form-data">
    <label>Category:</label>
    <select name="category" required>
        <option value="Dogs">Dogs</option>
        <option value="Cats">Cats</option>
    </select><br>

    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Content:</label>
    <textarea name="content" rows="6" required></textarea><br>

    <label>Image:</label>
    <input type="file" name="image"><br>

    <button class="btn2" type="submit" name="action" value="add">Add Content</button>
</form>

<hr>

<!-- Edit and Remove Content -->
<h2>Edit or Remove Content</h2>

<?php if (!empty($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="content_id" value="<?php echo htmlspecialchars($article['ContentID']); ?>">

            <label>Category:</label>
            <select name="category" required>
                <option value="Dogs" <?php echo $article['Category'] == 'Dogs' ? 'selected' : ''; ?>>Dogs</option>
                <option value="Cats" <?php echo $article['Category'] == 'Cats' ? 'selected' : ''; ?>>Cats</option>
            </select><br>

            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($article['Title']); ?>" required><br>

            <label>Content:</label>
            <textarea name="content" rows="6" required><?php echo htmlspecialchars($article['Content']); ?></textarea><br>

            <label>Current Image:</label>
            <?php if ($article['ImageURL']): ?>
                <img src="<?php echo htmlspecialchars($article['ImageURL']); ?>" alt="Content Image" width="100"><br>
            <?php else: ?>
                No image uploaded.<br>
            <?php endif; ?>

            <label>Upload New Image (optional):</label>
            <input type="file" name="image"><br>

            <button class="btn2" type="submit" name="action" value="edit">Save Changes</button>
            <button class="btn2" type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this content?');">Delete</button>
        </form>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>No content available to manage.</p>
<?php endif; ?>

<!-- Footer from partials -->
<?php include('partials/footer_admin.php'); ?>
</body>
</html>
