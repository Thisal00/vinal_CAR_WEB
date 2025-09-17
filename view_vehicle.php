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

// Additional images example (you can fetch from DB or JSON)
$extra_images = [];
if (!empty($vehicle['image2'])) $extra_images[] = "/vinal_auto/assets/images/uploads/" . htmlspecialchars($vehicle['image2']);
if (!empty($vehicle['image3'])) $extra_images[] = "/vinal_auto/assets/images/uploads/" . htmlspecialchars($vehicle['image3']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($vehicle['make'].' '.$vehicle['model']) ?> - Vinal Auto</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
:root {
  --brand-bg: #0b1e3f;
  --brand-gold: #ffd700;
  --panel: #11182e;
  --text: #fff;
  --whatsapp: #25D366;
  --email: #1E90FF;
}

/* Body */
body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--brand-bg);
    color: var(--text);
    margin: 0;
    padding-top: 140px; /* for fixed navbar */
}

/* Navbar */
.navbar { background: rgba(0,0,0,0.85); }
.navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
.navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

/* Vehicle Card */
.vehicle-card {
    background: var(--panel);
    border-radius: 12px;
    padding: 25px;
    max-width: 900px;
    margin: 0 auto 50px auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.5);
}

/* Vehicle Carousel */
.carousel-inner img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 12px;
}

/* Buttons */
.btn-contact {
    font-weight: bold;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    margin-top: 10px;
    display: block;
    text-align: center;
    transition: 0.3s;
    color: #fff;
    text-decoration: none;
}
.btn-whatsapp { background-color: var(--whatsapp); }
.btn-whatsapp:hover { background-color: #1ebe5d; }
.btn-email { background-color: var(--email); }
.btn-email:hover { background-color: #187bcd; }

/* Description */
.vehicle-card p {
    line-height: 1.6;
    font-size: 14px;
    color: #eee;
}

/* Muted info */
.muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }

/* Footer */
footer {
  background: #010205ff;
  color: #ddd;
  padding: 40px 0 20px;
}
footer h5 { color: var(--brand-gold); margin-bottom: 15px; }
footer p, footer a { color: #bbb; font-size: 14px; }
footer a:hover { color: #fff; text-decoration: none; }
.footer-link { display: block; margin-bottom: 5px; }
</style>
</head>
<body>

<!-- Navbar -->
<?php include 'a_nav.php'; ?>

<!-- Vehicle Details -->
<div class="vehicle-card" id="vehicleCard">
    <h2><?= htmlspecialchars($vehicle['year'].' '.$vehicle['make'].' '.$vehicle['model']) ?></h2>

    <!-- Carousel -->
    <div id="vehicleCarousel" class="carousel slide mb-3" data-ride="carousel">
      <div class="carousel-inner">
        <?php
        $main_image = !empty($vehicle['image']) ? "/vinal_auto/assets/images/uploads/".htmlspecialchars($vehicle['image']) : "/vinal_auto/assets/images/no-car.png";
        $images = array_merge([$main_image], $extra_images);
        foreach ($images as $index => $img) {
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active'><img src='$img' class='d-block w-100 vehicle-img'></div>";
        }
        ?>
      </div>
      <a class="carousel-control-prev" href="#vehicleCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#vehicleCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

    <div class="muted">Price: LKR <?= number_format($vehicle['price'], 2) ?></div>
    <div class="muted">Fuel: <?= htmlspecialchars($vehicle['fuel']) ?> | Transmission: <?= htmlspecialchars($vehicle['transmission']) ?> | Mileage: <?= number_format($vehicle['mileage']) ?> km</div>
    <div class="muted">Added: <?= date("d M Y", strtotime($vehicle['created_at'])) ?></div>

    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>

    <!-- Contact Buttons -->
    <a href="https://wa.me/94768291088?text=Hi%20I%27m%20interested%20in%20the%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
       target="_blank" class="btn-contact btn-whatsapp">💬 Contact on WhatsApp</a>

    <a href="mailto:thisalchathnuka@gmail.com?subject=Interested%20in%20<?= urlencode($vehicle['make'].' '.$vehicle['model']) ?>" 
       class="btn-contact btn-email">📧 Contact via Email</a>

    <a href="/vinal_auto/vehicles.php" class="btn btn-secondary mt-3">← Back to Vehicles</a>
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
        <a href="index.php" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="parts.php" class="footer-link">Parts</a>
        <a href="book-test-drive.php" class="footer-link">Booking</a>
        <a href="reviews.php" class="footer-link">Reviews</a>
        <a href="about.php" class="footer-link">About</a>
        <a href="contact.php" class="footer-link">Contact</a>
      </div>
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
        </form>
      </div>
    </div>
    <hr style="border-color: rgba(255,255,255,0.1)">
    <div class="row">
      <div class="col-md-6">
        <p class="mb-0">&copy; <?= date('Y') ?> Vinal Auto Traders. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-md-right text-left">
        <a href="#" class="footer-link d-inline">Privacy Policy</a>
        <a href="#" class="footer-link d-inline ml-3">Terms of Use</a>
        <a href="#" class="footer-link d-inline ml-3">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Animate vehicle card
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("vehicleCard").classList.add("show");
});
</script>
</body>
</html>
