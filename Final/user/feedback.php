<?php
include 'db.php';

session_start();

// Fetch UserID from the session
$userID = $_SESSION['UserID'] ?? null; // Fetch UserID from session, or set to null if not available

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || !$userID) {
    header("Location: ../login/user_login.php"); // Redirect to login page if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Feedback Section */
    .feedback {
      display: flex;
      flex-direction: column;
    }

    .feedback-hero {
      display: flex;
      /* flex-direction: row; */
      text-align: left;
      justify-content: space-around;
    }

    .feedback-hero img{
      width: 50%;
    }

    .feedback-list {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }

    /* Individual Feedback Item */
    .feedback-item {
      background-color: var(--purple-white);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      max-width: 900px;
      margin: 36px auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-end;
    }

    .feedback-form{
      padding: 24px;
      background-color: var(--purple-white);
      margin-left: 12px;
    }

    .feedback-form-container {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      max-width: 1200px;
    }
    
    .feedback-form-container .form-info, .feedback-form-container .feedback-form {
      width: 48%;
      text-align: left;
    }

    .feedback-form-container textarea, .feedback-form-container input {
      width: 100%;
      padding: 10px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }



    .message.success {
      background-color: #d4edda;
      color: #155724;
      padding: 5px;
    }
    .message.error {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
    }

    @media (max-width: 768px) {

      .feedback-hero {
        display: flex;
        flex-direction: column-reverse;
        text-align: center;
        justify-content: space-around;
        align-items: center;
      }

      .feedback-form-container {
          flex-direction: column;
          align-items: center;
      }

      .feedback-form-container .form-info, .feedback-form-container .feedback-form {
        width: 96%;
        text-align: left;
      }
    }
  </style>
</head>
<body>
<?php
//header from partials
include('partials/header_user.php');
?>
  <section class="feedback">
    <div class="feedback container">
      <div class="feedback-hero container">
        <div>
          <h1>Your Voice Matters!</h1>
          <p>Help us improve by sharing your thoughts, experiences, and suggestions. We're committed to making Street Hearts the best it can be for our pets and community.</p>
          <div class="cta-btn">
            <a href="#feedback-form" class="btn primary-btn">Submit Your Feedback</a>
          </div>
        </div>
        <img src="assests\feedback_hero.jpg" alt="feddback-img">
      </div>
      <?php
      try {
          // Fetch user details using UserID from session
          $stmtUser = $pdo->prepare("SELECT Username FROM users WHERE UserID = :UserID");
          $stmtUser->execute(['UserID' => $userID]);
          $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

          if (!$user) {
              echo "Invalid user information.";
              exit;
          }
      } catch (PDOException $e) {
          echo "Error fetching details: " . $e->getMessage();
          exit;
      }
      ?>
    </div>
  </section>

  <section>
    <div class="container">
      <h2>Previous Feedback</h2>
    </div>
      <div class="feedback-list">
        <div class="feedback-item">
          <?php
          // Fetch and display feedback
          $sql = "SELECT f.Rating, f.Comments, f.FeedbackDate, u.Username FROM feedback f JOIN users u ON f.UserID = u.UserID ORDER BY f.FeedbackDate DESC";
          $stmt = $pdo->query($sql);
          $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (!empty($feedbacks)) {
              foreach ($feedbacks as $feedback) {
                  echo "<p><strong>{$feedback['Username']}</strong> rated <strong>{$feedback['Rating']}/5</strong></p>";
                  echo "<p>Comments: {$feedback['Comments']}</p>";
                  echo "<p>Date: {$feedback['FeedbackDate']}</p>";
                  echo "<hr>";
              }
          } else {
              echo "<p>No feedback yet.</p>";
          }
          ?>
        </div>
      </div>
  </section>

  <section>
    <!-- Feedback Form Section -->
    <div id="feedback-form" class="feedback-form-container container">
      <div class="form-info">
          <h2>We Want to Hear From You</h2>
          <p>Please fill out the form below to share your feedback. Your responses are confidential and will be used to improve our services.</p>
      </div>
      <div class="feedback-form">
        <h3>Submit Your Feedback</h3>
        <!-- Display success or error messages -->
        <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
            <div class="message <?php echo ($_GET['status'] === 'success') ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        <form action="submit_feedback.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments" rows="4" required></textarea>
            </div>

            <input type="hidden" name="UserID" value="<?php echo $userID; ?>">

            <button type="submit" class="btn primary-btn">Submit Feedback</button>
        </form>
      </div>
    </div>
  </section>
  
 <!-- Footer from partials -->
 <?php include('partials/footer_user.php'); ?>

</body>
</html>