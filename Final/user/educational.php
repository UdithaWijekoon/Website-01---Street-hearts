<?php
include 'db.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch articles based on category
$category = isset($_GET['category']) ? $_GET['category'] : 'Dogs';
$sql = "SELECT * FROM educational_content WHERE Category = :category ORDER BY DatePosted DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['category' => $category]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Content - <?php echo htmlspecialchars($category); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        nav {
            text-align: center;
            margin-bottom: 30px;
        }

        .back-container a {
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: #007BFF;
            color: #fff;
        }

        hr {
            border: none;
            height: 2px;
            background-color: #ddd;
            margin: 20px 0;
        }

        .back-container {
            text-align: left;
            margin-bottom: 20px;
        }

        
        .article {
            background-color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .article img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .article h2 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .article p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            text-align: justify;
        }

        .article .posted-date {
            color: #999;
            font-size: 0.9em;
            margin-top: 15px;
            font-style: italic;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Educational Content for <?php echo htmlspecialchars($category); ?></h1>

    <nav>
        <a href="educational.php?category=Dogs">Dogs</a>
        <a href="educational.php?category=Cats">Cats</a>
    </nav>



    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?php echo htmlspecialchars($article['Title']); ?></h2>
                <?php if ($article['ImageURL']): ?>
                    <img src="<?php echo htmlspecialchars($article['ImageURL']); ?>" alt="<?php echo htmlspecialchars($article['Title']); ?>">
                <?php endif; ?>
                <p><?php echo nl2br(htmlspecialchars($article['Content'])); ?></p>
                <p class="posted-date"><strong>Posted on:</strong> <?php echo date('F j, Y', strtotime($article['DatePosted'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No articles found for <?php echo htmlspecialchars($category); ?>.</p>
    <?php endif; ?>

    <div class="back-container">
        <a href="edu_content.php" class="btn primary-btn">Back</a>
    </div>
</div>

</body>
</html>
