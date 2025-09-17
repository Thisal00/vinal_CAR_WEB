<?php
include 'db.php';

// Get and sanitize part ID
$part_id = $_GET['id'] ?? 0;
$safe_id = mysqli_real_escape_string($conn, $part_id);

// Fetch part
$result = mysqli_query($conn, "SELECT * FROM vehicle_parts WHERE id = '$safe_id' LIMIT 1");
if (!$result || mysqli_num_rows($result) === 0) {
  echo "<p>Part not found.</p><a href='/vinal_auto/user_parts.php'>← Back to Parts</a>";
  exit;
}
$part = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Part Details - <?= htmlspecialchars($part['part_name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
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

    .navbar { background: rgba(0,0,0,0.85); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    .part-card {
      background: #11182E;
      color: #ffffffff;
      border-radius: 12px;
      padding: 25px;
      margin-top: 90px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 10px 18px; margin-right: 8px; }
    .btn-buy { background: #007bff; color: white; }
    .btn-email { background: #657995ff; color: white; }
    .btn-whatsapp { background: #25D366; color: white; }
    #buyForm { display: none; margin-top: 20px; }

 
  </style>
</head>
<body>

<!-- Navbar -->
  <?php include 'a_nav.php'; ?>
<!-- Part Details -->
<div class="container">
  <div class="part-card">
    <h2><?= htmlspecialchars($part['part_name']) ?></h2>

    <?php
    $image_path = "/vinal_auto/assets/uploads/" . htmlspecialchars($part['image']);
    $full_path = $_SERVER['DOCUMENT_ROOT'] . $image_path;

    if (!empty($part['image']) && file_exists($full_path)) {
      echo "<img src='$image_path' class='img-fluid rounded mb-3' alt='Image of " . htmlspecialchars($part['part_name']) . "'>";
    } else {
      echo "<img src='/vinal_auto/assets/default.jpg' class='img-fluid rounded mb-3' alt='Default image'>";
    }
    ?>

    <div class="price">Rs. <?= number_format($part['price'], 2) ?></div>
    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($part['description'])) ?></p>
    <p><strong>Stock:</strong> <?= ($part['stock'] > 0) ? "✅ Available ({$part['stock']} left)" : "❌ Out of Stock"; ?></p>

    <!-- Action Buttons -->
    <a href="mailto:admin@example.com?subject=Buy Request for <?= urlencode($part['part_name']) ?>" class="btn btn-email btn-custom">Email Admin</a>
    <a href="https://wa.me/94768291088?text=Hello,%20I%20want%20to%20buy%20<?= urlencode($part['part_name']) ?>" target="_blank" class="btn btn-whatsapp btn-custom">WhatsApp Admin</a>
    <a href="#" class="btn btn-buy btn-custom" onclick="document.getElementById('buyForm').style.display='block'">Buy Now</a>

    <!-- Buy Form -->
    <div id="buyForm">
      <form method="POST" action="/vinal_auto/submit_order.php">
        <input type="hidden" name="part_id" value="<?= $part['id'] ?>">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Confirm Order</button>
      </form>
    </div>

    <br><a href="/vinal_auto/parts.php" class="btn btn-secondary mt-3">← Back to Parts</a>
  </div>
</div>

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
        <a href="index.php" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="parts.php" class="footer-link">Parts</a>
        <a href="book-test-drive.php" class="footer-link">Booking</a>
        <a href="reviews.php" class="footer-link">Reviews</a>
        <a href="about.php" class="footer-link">About</a>
        <a href="contact.php" class="footer-link">Contact</a>
      </div>

      <!-- Newsletter -->
      <div class="col-md-4 mb-4">
        <h5>Newsletter</h5>
        <p>Get the latest deals straight to your inbox.</p>
        <form id="newsletterForm" method="POST">
          <div class="input-group">
            <input type="email"
                   name="newsletter_email"
                   class="form-control"
                   placeholder="Your email"
                   required>
            <div class="input-group-append">
              <button class="btn btn-warning" type="submit">Subscribe</button>
            </div>
          </div>
          <?php if (!empty($newsletter_msg)): ?>
            <small class="form-text text-light mt-2">
              <?= htmlspecialchars($newsletter_msg) ?>
            </small>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <hr style="border-color: rgba(255,255,255,0.1)">

    <div class="row">
      <div class="col-md-6">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Vinal Auto Traders. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-md-right text-left">
        <a href="https://example.com/privacy-policy" class="footer-link d-inline">Privacy Policy</a>
        <a href="https://example.com/terms-of-use" class="footer-link d-inline ml-3">Terms of Use</a>
        <a href="https://example.com/sitemap" class="footer-link d-inline ml-3">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<!-- Footer Styles -->
<style>
/* Footer */
footer {
  background: #010205ff;
  color: #ddd;
  padding: 40px 0 20px;
  margin-top: 50px;
}
footer h5 {
  color: var(--brand-gold);
  margin-bottom: 15px;
}
footer p,
footer a {
  color: #bbb;
  font-size: 14px;
}
footer a:hover {
  color: #fff;
  text-decoration: none;
}
.footer-link {
  display: block;
  margin-bottom: 5px;
}
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>