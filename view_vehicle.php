<?php
include 'db.php';

// Get vehicle ID
$vehicle_id = $_GET['id'] ?? 0;
$safe_id = mysqli_real_escape_string($conn, $vehicle_id);

// Fetch vehicle
$result = mysqli_query($conn, "SELECT * FROM vehicles WHERE id='$safe_id' LIMIT 1");
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>Vehicle not found.</p><a href='/vinal_auto/vehicles.php'>← Back to Vehicles</a>";
    exit;
}
$vehicle = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vehicle Details - <?= htmlspecialchars($vehicle['make'].' '.$vehicle['model']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

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

.vehicle-card {
  background: var(--panel);
  border-radius: 12px;
  padding: 25px;
  margin-top: 90px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  opacity: 0;
  transform: translateY(20px);
  transition: 0.5s;
}

.vehicle-card.show {
  opacity: 1;
  transform: translateY(0);
}

.vehicle-card img.vehicle-img {
  width: 100%;
  height: auto;
  max-height: 500px; /* prevent huge images */
  object-fit: contain;
  border-radius: 12px;
  margin-bottom: 15px;
}

.vehicle-card .btn-book {
  background-color: var(--brand-gold);
  color: #111;
  font-weight: bold;
  border: none;
  padding: 10px 18px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.3s;
  text-decoration: none;
  display: block;
}
.vehicle-card .btn-book:hover { background-color: #fff176; }

.muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }

footer {
  background: #101010;
  padding: 30px 0;
  color: #aaa;
  margin-top: 40px;
}
footer h5 { color: var(--brand-gold); }
.footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; }
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
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/user_parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/contact.php">Contact</a></li>
    </ul>
  </div>
</nav>

<!-- Vehicle Details -->
<div class="container">
  <div class="vehicle-card" id="vehicleCard">
    <h2><?= htmlspecialchars($vehicle['year'].' '.$vehicle['make'].' '.$vehicle['model']) ?></h2>

    <?php
    $image_path = "/vinal_auto/assets/images/uploads/" . htmlspecialchars($vehicle['image']);
    $full_path = $_SERVER['DOCUMENT_ROOT'] . $image_path;

    if (!empty($vehicle['image']) && file_exists($full_path)) {
        echo "<img src='$image_path' alt='Vehicle Image' class='vehicle-img'>";
    } else {
        echo "<img src='/vinal_auto/assets/images/no-car.png' alt='Default Vehicle' class='vehicle-img'>";
    }
    ?>

    <div class="muted">Price: LKR <?= number_format($vehicle['price'], 2) ?></div>
    <div class="muted">Fuel: <?= htmlspecialchars($vehicle['fuel']) ?> | Transmission: <?= htmlspecialchars($vehicle['transmission']) ?> | Mileage: <?= number_format($vehicle['mileage']) ?> km</div>
    <div class="muted">Added: <?= date("d M Y", strtotime($vehicle['created_at'])) ?></div>

    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>

    <!-- Contact Options -->
    <div class="mt-3">
      <a href="https://wa.me/94768291088?text=Hi%20I%27m%20interested%20in%20the%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
         target="_blank" 
         class="btn-book mb-2 text-center">
         💬 Contact on WhatsApp
      </a>

      <a href="mailto:thisalchathnuka@gmail.com?subject=Interested%20in%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
         class="btn-book text-center">
         📧 Contact via Email
      </a>
    </div>

    <br><a href="/vinal_auto/vehicles.php" class="btn btn-secondary mt-3">← Back to Vehicles</a>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Animate vehicle card on load
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("vehicleCard").classList.add("show");
});
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vehicle Details - <?= htmlspecialchars($vehicle['make'].' '.$vehicle['model']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

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

.vehicle-card {
  background: var(--panel);
  border-radius: 12px;
  padding: 25px;
  margin-top: 90px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  opacity: 0;
  transform: translateY(20px);
  transition: 0.5s;
}

.vehicle-card.show {
  opacity: 1;
  transform: translateY(0);
}

.vehicle-card img.vehicle-img {
  width: 100%;
  height: auto;
  max-height: 500px; /* prevent huge images */
  object-fit: contain;
  border-radius: 12px;
  margin-bottom: 15px;
}

.vehicle-card .btn-book {
  background-color: var(--brand-gold);
  color: #111;
  font-weight: bold;
  border: none;
  padding: 10px 18px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.3s;
  text-decoration: none;
  display: block;
}
.vehicle-card .btn-book:hover { background-color: #fff176; }

.muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }

footer {
  background: #101010;
  padding: 30px 0;
  color: #aaa;
  margin-top: 40px;
}
footer h5 { color: var(--brand-gold); }
.footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; }
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
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/user_parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/contact.php">Contact</a></li>
    </ul>
  </div>
</nav>
<!-- Vehicle Details -->
<div class="container">
  <div class="vehicle-card" id="vehicleCard">
    <h2><?= htmlspecialchars($vehicle['year'].' '.$vehicle['make'].' '.$vehicle['model']) ?></h2>

 php add karapan 

    <div class="muted">Price: LKR <?= number_format($vehicle['price'], 2) ?></div>
    <div class="muted">Fuel: <?= htmlspecialchars($vehicle['fuel']) ?> | Transmission: <?= htmlspecialchars($vehicle['transmission']) ?> | Mileage: <?= number_format($vehicle['mileage']) ?> km</div>
    <div class="muted">Added: <?= date("d M Y", strtotime($vehicle['created_at'])) ?></div>

    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>

    <!-- Contact Options -->
    <div class="mt-3">
      <a href="https://wa.me/94768291088?text=Hi%20I%27m%20interested%20in%20the%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
         target="_blank" 
         class="btn-book mb-2 text-center">
         💬 Contact on WhatsApp
      </a>

      <a href="mailto:thisalchathnuka@gmail.com?subject=Interested%20in%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
         class="btn-book text-center">
         📧 Contact via Email
      </a>
    </div>

    <br><a href="/vinal_auto/vehicles.php" class="btn btn-secondary mt-3">← Back to Vehicles</a>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Animate vehicle card on load
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("vehicleCard").classList.add("show");
});
</script>
</body>
</html>
