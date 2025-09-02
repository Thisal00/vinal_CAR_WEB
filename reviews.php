<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reviews - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <style>
    :root {
      --brand-bg: #0b1e3f;
      --brand-gold: #ffd700;
      --panel: #11182e;
      --text: #f4f4f4;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
    }

    h2, h3 { color: var(--brand-gold); }

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    /* Review Cards */
    .review-card {
      background: var(--panel);
      padding: 1.5rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .review-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.4);
    }
    .review-head {
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .review-head span { color: var(--brand-gold); }
    .muted { color: #bbb; font-size: 0.85rem; }

    /* Form */
    form.card {
      background: var(--panel);
      color: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      margin-top: 2rem;
    }
    form.card input, form.card textarea, form.card select {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1rem;
      border-radius: 6px;
      border: none;
    }
    form.card button {
      background: var(--brand-gold);
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      color: #0b1c39;
    }

    .alert {
      background: #222d44;
      color: var(--brand-gold);
      padding: 10px 15px;
      border-radius: 6px;
      margin-top: 1rem;
    }

    /* Footer */
    footer {
      background: #101010;
      padding: 30px 0;
      color: #aaa;
      margin-top: 40px;
    }
    footer h5 { color: var(--brand-gold); }
    .footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; }
    .footer-link:hover { color: #fff; }

    /* Social Links */
    .social-links a {
      color: var(--text);
      margin-right: 15px;
      font-size: 1.5rem;
      transition: color 0.3s;
    }
    .social-links a:hover { color: var(--brand-gold); }

    /* WhatsApp Button */
    .whatsapp-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #25d366;
      color: #fff;
      padding: 12px 16px;
      border-radius: 50px;
      font-size: 1.5rem;
      z-index: 1000;
      box-shadow: 0 3px 6px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a class="navbar-brand text-warning" href="index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link" href="parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link active" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

<main class="container" style="margin-top:90px; max-width:900px;">
  <h2>Customer Reviews</h2>

  <div class="reviews">
    <?php
      $sql = "SELECT name, rating, comment, created_at FROM reviews WHERE status='approved' ORDER BY id DESC";
      if ($res = $mysqli->query($sql)) {
        while ($r = $res->fetch_assoc()) {
          echo '<div class="review-card">';
          echo '  <div class="review-head"><strong>'.htmlspecialchars($r['name']).'</strong><span>'.(int)$r['rating'].'/5</span></div>';
          echo '  <p>'.htmlspecialchars($r['comment']).'</p>';
          echo '  <div class="muted">'.htmlspecialchars($r['created_at']).'</div>';
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
          $msg = "✅ Thanks! Your review is submitted for approval.";
      } else {
          $msg = "⚠️ Please fill all fields correctly.";
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

  <!-- Social Links -->
  <div class="social-links mt-4 text-center">
    <a href="https://facebook.com/YourPage" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="https://instagram.com/YourPage" target="_blank"><i class="fab fa-instagram"></i></a>
    <a href="https://www.tiktok.com/@YourPage" target="_blank"><i class="fab fa-tiktok"></i></a>
    <a href="mailto:info@vinalauto.lk"><i class="fas fa-envelope"></i></a>
  </div>
</main>

<!-- WhatsApp Button -->
<a href="https://wa.me/94771234567" class="whatsapp-btn" target="_blank"><i class="fab fa-whatsapp"></i></a>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <!-- Contact Info -->
      <div class="col-md-4 mb-4">
        <h5>Contact Us</h5>
        <p>
          123 Car Street, Colombo<br>
          Phone: +94 77 123 4567<br>
          Email: info@vinalauto.lk
        </p>
      </div>
      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5>Quick Links</h5>
        <a href="index.php" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="about.php" class="footer-link">About</a>
        <a href="contact.php" class="footer-link">Contact</a>
      </div>
      <!-- Newsletter -->
      <div class="col-md-4 mb-4">
        <h5>Newsletter</h5>
        <p>Get the latest deals straight to your inbox.</p>
        <form>
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Your email" required>
            <div class="input-group-append">
              <button class="btn btn-warning" type="submit">Subscribe</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <hr style="border-color: rgba(255,255,255,0.1)">

    <div class="row">
      <div class="col-md-6">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Vinal Auto Traders. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-right">
        <a href="#" class="footer-link d-inline">Privacy Policy</a>
        <a href="#" class="footer-link d-inline">Terms of Use</a>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
