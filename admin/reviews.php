<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reviews - Vinal Auto</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <h1 class="logo"><a href="index.php">Vinal Auto</a></h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="vehicles.php">Vehicles</a>
      <a href="reviews.php" class="active">Reviews</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a class="btn" href="admin/login.php">Admin</a>
    </nav>
  </div>
</header>

<main class="container">
  <h2>Customer Reviews</h2>

  <div class="reviews">
    <?php
      $sql = "SELECT name, rating, comment, created_at FROM reviews WHERE status='approved' ORDER BY id DESC";
      if ($res = $mysqli->query($sql)) {
        while ($r = $res->fetch_assoc()) {
          echo '<div class="review">';
          echo '  <div class="review-head"><strong>'.e($r['name']).'</strong><span>'.(int)$r['rating'].'/5</span></div>';
          echo '  <p>'.e($r['comment']).'</p>';
          echo '  <div class="muted">'.e($r['created_at']).'</div>';
          echo '</div>';
        }
      }
    ?>
  </div>

  <hr>
  <h3>Leave a review</h3>
  <?php
  $msg = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name'] ?? '');
      $rating = (int)($_POST['rating'] ?? 0);
      $comment = trim($_POST['comment'] ?? '');
      if ($name && $rating >=1 && $rating <=5 && $comment) {
          $stmt = $mysqli->prepare("INSERT INTO reviews (vehicle_id, name, rating, comment, status) VALUES (NULL,?,?,?, 'pending')");
          $stmt->bind_param('sis', $name, $rating, $comment);
          $stmt->execute();
          $stmt->close();
          $msg = "Thanks! Your review is submitted for approval.";
      } else {
          $msg = "Please fill all fields correctly.";
      }
  }
  if ($msg) { echo '<div class="alert">'.$msg.'</div>'; }
  ?>
  <form method="post" class="card form">
    <input type="text" name="name" placeholder="Your name" required>
    <select name="rating" required>
      <option value="">Rating</option>
      <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
    </select>
    <textarea name="comment" placeholder="Your review" required></textarea>
    <button class="btn">Submit</button>
  </form>
</main>

<footer class="site-footer"><div class="container">&copy; <?php echo date('Y'); ?> Vinal Auto</div></footer>
</body>
</html>
