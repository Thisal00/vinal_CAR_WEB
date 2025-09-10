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
      --card-hover: #1b2a58;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
      scroll-behavior: smooth;
    }

    h2, h3 { color: var(--brand-gold); }

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); transition: background 0.3s; }
    .navbar.scrolled { background: var(--panel) !important; }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; transition: color 0.3s; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    /* Review Cards */
    .review-card {
      background: var(--panel);
      padding: 1.5rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      opacity: 0;
      transform: translateY(30px);
      animation: slideUp 0.6s forwards;
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    }
    .review-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      background: var(--card-hover);
    }
    @keyframes slideUp {
      to { opacity: 1; transform: translateY(0); }
    }

    .review-head { display: flex; justify-content: space-between; font-weight: 600; margin-bottom: 0.5rem; }
    .review-head .stars { color: var(--brand-gold); font-size: 1rem; }

    .review-card .stars i {
      opacity: 0;
      transform: scale(0.5);
      display: inline-block;
      animation: starPop 0.4s forwards;
    }
    .review-card .stars i:nth-child(1) { animation-delay: 0.1s; }
    .review-card .stars i:nth-child(2) { animation-delay: 0.2s; }
    .review-card .stars i:nth-child(3) { animation-delay: 0.3s; }
    .review-card .stars i:nth-child(4) { animation-delay: 0.4s; }
    .review-card .stars i:nth-child(5) { animation-delay: 0.5s; }

    @keyframes starPop {
      to { opacity: 1; transform: scale(1); }
    }

    .muted { color: #bbb; font-size: 0.85rem; }

    /* Review Form */
    form.card {
      background: var(--panel);
      color: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      margin-top: 2rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      transition: transform 0.3s;
    }
    form.card:hover { transform: scale(1.01); }
    form.card input, form.card textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      border: none;
      background: #1b2a4a;
      color: #f4f4f4;
    }
    form.card button {
      background: var(--brand-gold);
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      color: #0b1c39;
      transition: background 0.3s;
    }
    form.card button:hover { background: #e6c200; }

    /* Star Rating in form */
    .star-rating i {
      font-size: 1.5rem;
      color: #ccc;
      cursor: pointer;
      transition: color 0.3s, transform 0.2s;
      margin-right: 5px;
    }
    .star-rating i.hovered,
    .star-rating i.selected {
      color: var(--brand-gold);
      transform: scale(1.2);
    }

    /* Alerts */
    .alert {
      background: #222d44;
      color: var(--brand-gold);
      padding: 10px 15px;
      border-radius: 6px;
      margin-top: 1rem;
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }

    /* Footer */
    footer {
      background: #101010;
      padding: 30px 0;
      color: #aaa;
      margin-top: 40px;
    }
    footer h5 { color: var(--brand-gold); }
    .footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; transition: color 0.3s; }
    .footer-link:hover { color: #fff; }

    /* Social Links */
    .social-links a {
      color: var(--text);
      margin-right: 15px;
      font-size: 1.5rem;
      transition: color 0.3s, transform 0.3s;
    }
    .social-links a:hover { color: var(--brand-gold); transform: scale(1.2); }

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
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .whatsapp-btn:hover { transform: scale(1.1); box-shadow: 0 6px 12px rgba(0,0,0,0.5); }
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
        $delay = 0;
        while ($r = $res->fetch_assoc()) {
          $rating = (int)$r['rating'];
          echo '<div class="review-card" style="animation-delay: '.$delay.'s">';
          echo '  <div class="review-head"><strong>'.htmlspecialchars($r['name']).'</strong><span class="stars">';
          
          // Star system
          for ($i = 1; $i <= 5; $i++) {
              if ($i <= $rating) echo '<i class="fas fa-star"></i>';
              else echo '<i class="far fa-star"></i>';
          }

          echo '</span></div>';
          echo '  <p>'.htmlspecialchars($r['comment']).'</p>';
          echo '  <div class="muted">'.htmlspecialchars($r['created_at']).'</div>';
          echo '</div>';
          $delay += 0.1;
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

  <form method="post" class="card form" id="reviewForm">
    <input type="text" name="name" placeholder="Your name" required>

    <div class="star-rating mb-3">
      <i class="far fa-star" data-value="1"></i>
      <i class="far fa-star" data-value="2"></i>
      <i class="far fa-star" data-value="3"></i>
      <i class="far fa-star" data-value="4"></i>
      <i class="far fa-star" data-value="5"></i>
    </div>
    <input type="hidden" name="rating" id="ratingInput" required>

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
      <!-- Contact -->
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
        <a href="#" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="#" class="footer-link">About</a>
        <a href="#" class="footer-link">Services</a>
        <a href="#" class="footer-link">Contact</a>
      </div>
      <!-- Newsletter -->
      <div class="col-md-4 mb-4">
        <h5>Newsletter</h5>
        <p>Get the latest deals straight to your inbox.</p>
        <form id="newsletterForm" method="POST">
          <div class="input-group">
            <input type="email" name="newsletter_email" class="form-control" placeholder="Your email" required>
            <div class="input-group-append">
              <button class="btn btn-warning" type="submit">Subscribe</button>
            </div>
          </div>
          <?php if (!empty($newsletter_msg)): ?>
            <small class="form-text text-light mt-2"><?= htmlspecialchars($newsletter_msg) ?></small>
          <?php endif; ?>
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
        <a href="#" class="footer-link d-inline">Sitemap</a>
      </div>
    </div>
  </div>
</footer>


</body>
</html>

