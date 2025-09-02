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
      background: #fff;
      color: #000;
      border-radius: 12px;
      padding: 25px;
      margin-top: 90px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 10px 18px; margin-right: 8px; }
    .btn-buy { background: #007bff; color: white; }
    .btn-email { background: #6c757d; color: white; }
    .btn-whatsapp { background: #25D366; color: white; }
    #buyForm { display: none; margin-top: 20px; }

    footer {
      background: #101010;
      padding: 30px 0;
      color: #aaa;
      margin-top: 40px;
    }
    footer h5 { color: var(--brand-gold); }
    .footer-link {
      display: block;
      color: #bbb;
      margin-bottom: 6px;
      text-decoration: none;
    }
    .footer-link:hover { color: #fff; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a class="navbar-brand text-warning" href="/vinal_auto/index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link active" href="/vinal_auto/user_parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="/vinal_auto/admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

<!-- Part Details -->
<div class="container">
  <div class="part-card">
    <h2><?= htmlspecialchars($part['part_name']) ?></h2>

    <?php if ($part['image']): ?>
      <img src="/vinal_auto/uploads/<?= htmlspecialchars($part['image']) ?>" class="img-fluid rounded mb-3" alt="Image of <?= htmlspecialchars($part['part_name']) ?>">
    <?php else: ?>
      <p><em>No image available.</em></p>
    <?php endif; ?>

    <div class="price">Rs. <?= number_format($part['price'], 2) ?></div>
    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($part['description'])) ?></p>
    <p><strong>Stock:</strong> <?= ($part['stock'] > 0) ? "✅ Available ({$part['stock']} left)" : "❌ Out of Stock"; ?></p>

    <!-- Action Buttons -->
    <a href="mailto:admin@example.com?subject=Buy Request for <?= urlencode($part['part_name']) ?>" class="btn btn-email btn-custom">📧 Email Admin</a>
    <a href="https://wa.me/94712345678?text=Hello,%20I%20want%20to%20buy%20<?= urlencode($part['part_name']) ?>" target="_blank" class="btn btn-whatsapp btn-custom">💬 WhatsApp Admin</a>
    <a href="#" class="btn btn-buy btn-custom" onclick="document.getElementById('buyForm').style.display='block'">🛒 Buy Now</a>

    <!-- Buy Form -->
    <div id="buyForm">
      <form method="POST" action="/vinal_auto/submit_order.php">
        <input type="hidden" name="part_id" value="<?= $part['id'] ?>">
        <div class="form-group">
          <label>ඔබගේ නම</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>දුරකථන අංකය</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Confirm Order</button>
      </form>
    </div>

    <br><a href="/vinal_auto/user_parts.php" class="btn btn-secondary mt-3">← Back to Parts</a>
  </div>
</div>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5>Contact Us</h5>
        <p>
          123 Car Street, Colombo<br>
          Phone: +94 77 123 4567<br>
          Email: info@vinalauto.lk
        </p>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Quick Links</h5>
        <a href="/vinal_auto/index.php" class="footer-link">Home</a>
        <a href="/vinal_auto/vehicles.php" class="footer-link">Vehicles</a>
        <a href="/vinal_auto/about.php" class="footer-link">About</a>
        <a href="/vinal_auto/contact.php" class="footer-link">Contact</a>
      </div>
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
        <p class="mb-0">&copy; <?= date('Y'); ?> Vinal Auto Traders. All