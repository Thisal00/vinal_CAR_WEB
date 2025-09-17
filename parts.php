<?php
require_once __DIR__.'/db.php';

// Search logic
$where = '';
$q = $_GET['q'] ?? '';
if (!empty($q)) {
  $safe_q = mysqli_real_escape_string($conn, $q);
  $where = "WHERE part_name LIKE '%$safe_q%'";
}

// Fetch parts
$result = mysqli_query($conn, "SELECT * FROM vehicle_parts $where ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Browse Vehicle Parts - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

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
    h2 { color: var(--brand-gold); }

    .navbar { background: rgba(0,0,0,0.85); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    .search-box {
      margin: 20px 0;
      background: #162b4d;
      padding: 15px;
      border-radius: 8px;
    }
    .search-box input {
      border: none;
      border-radius: 6px;
      padding: 10px;
      width: 250px;
      background: #0b1e3f;
      color: #fff;
    }
    .search-box input::placeholder { color: #bbb; }
    .search-box button {
      background: var(--brand-gold);
      border: none;
      padding: 10px 18px;
      border-radius: 6px;
      font-weight: bold;
      margin-left: 8px;
      color: #111;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 20px;
    }
    .part-card {
      background: var(--panel);
      border-radius: 10px;
      padding: 15px;
      transition: 0.3s;
      border: 1px solid #2c3e50;
    }
    .part-card:hover { transform: translateY(-5px); box-shadow: 0 6px 16px rgba(0,0,0,0.4); }
    .part-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 6px;
      margin-bottom: 10px;
    }
    .part-title { font-size: 18px; font-weight: bold; color: var(--brand-gold); }
    .part-price { font-weight: bold; color: lightgreen; margin: 5px 0; }
    .part-desc { font-size: 14px; color: #ddd; }

    .action-btns { margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px; }
    .action-btns a {
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 14px;
      color: #fff;
      text-decoration: none;
    }
    .view-btn { background: #0077cc; }
    .email-btn { background: #555; }
    .whatsapp-btn { background: #25D366; }

  </style>
</head>
<body>

<!-- Navbar -->
  <?php include 'a_nav.php'; ?>
<!-- Main -->
<main class="container" style="margin-top:90px; max-width:1200px;">
  <h2 class="mb-4">🛠 Available Vehicle Parts</h2>

  <!-- Search -->
  <form method="get" class="search-box d-flex">
    <input type="text" name="q" placeholder="Search part name..." value="<?= htmlspecialchars($q) ?>">
    <button type="submit">Search</button>
  </form>

  <!-- Parts Grid -->
  <div class="grid">
    <?php
    if (mysqli_num_rows($result) === 0) {
      echo "<p>No parts found.</p>";
    } else {
      while ($row = mysqli_fetch_assoc($result)) {
        $part_id = $row['id'];
        $part_name = urlencode($row['part_name']);
        $img_path = !empty($row['image']) ? 'assets/uploads/' . htmlspecialchars($row['image']) : 'assets/images/no-part.png';

        // Short description preview (100 chars max)
        $desc = htmlspecialchars($row['description']);
        $short_desc = (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc;

        echo "<div class='part-card animate__animated animate__fadeInUp'>
          <img src='$img_path' alt='Part Image'>
          <div class='part-title'>".htmlspecialchars($row['part_name'])."</div>
          <div class='part-price'>Rs. ".number_format($row['price'], 2)."</div>
          <div class='part-desc'>".$short_desc."</div>
          <div class='action-btns'>
            <a href='view_part.php?id=$part_id' class='view-btn'>View</a>
            <a href='mailto:thisalchathnuka@gmail.com?subject=Buy Request for $part_name&body=Hello, I want to buy this part.' class='email-btn'>Email</a>
            <a href='https://wa.me/947?text=Hello,%20I%20want%20to%20buy%20$part_name' target='_blank' class='whatsapp-btn'>WhatsApp</a>
          </div>
        </div>";
      }
    }
    ?>
  </div>
</main>

<!-- Footer -->
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

</body>
</html>
