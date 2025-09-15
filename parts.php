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
  <a class="navbar-brand text-warning" href="index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link active" href="parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

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
