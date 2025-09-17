<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About - Vinal Auto</title>
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

    h2, h3 { color: var(--brand-gold); }


    /* Hero Section */
    .hero {
      position: relative;
      height: 70vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      overflow: hidden;
      margin-top: 70px;
    }
    .hero video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      text-shadow: 2px 2px 8px #000;
    }
    .hero p { font-size: 1.3rem; }

    /* About Content */
    main.container { max-width: 900px; margin-top: 2rem; text-align: center; }

    /* Counters */
    .counters {
      padding: 60px 20px;
      background: var(--panel);
      display: flex;
      justify-content: center;
      gap: 80px;
      text-align: center;
      border-radius: 10px;
      margin-top: 2rem;
    }
    .counter-box h2 {
      font-size: 3rem;
      color: var(--brand-gold);
    }
    .counter-box p { margin-top: 10px; font-size: 1.2rem; color: var(--text); }

   
  </style>
</head>
<body>

<!-- Navbar -->
  <?php include 'a_nav.php'; ?>

<!-- Hero Section with Video -->
<section class="hero">
  <video autoplay muted loop>
    <source src="assets/videos/cars.mp4" type="video/mp4">
  </video>
  <div>
    <h1>About Vinal Auto</h1>
    <p>Trusted Auto Marketplace in Sri Lanka</p>
  </div>
</section>

<!-- About Content -->
<main class="container">
  <h2 class="mb-3">Who We Are</h2>
  <p>We are a Sri Lankan auto marketplace helping you buy and sell vehicles with confidence.</p>
  <p>Our mission is to connect buyers with quality vehicles at fair prices.</p>
</main>

<!-- Counters -->
<section class="counters">
  <div class="counter-box">
    <h2 id="vehicles-sold">0</h2>
    <p>Vehicles Sold</p>
  </div>
  <div class="counter-box">
    <h2 id="experience">0</h2>
    <p>Years of Experience</p>
  </div>
</section>

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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Counter Animation
  function animateCounter(id, target, duration) {
    const el = document.getElementById(id);
    let start = 0;
    const step = target / (duration / 50);
    const counter = setInterval(() => {
      start += step;
      if (start >= target) {
        start = target;
        clearInterval(counter);
      }
      el.textContent = Math.floor(start) + (id === 'vehicles-sold' ? '+' : '');
    }, 50);
  }

  let started = false;
  window.addEventListener('scroll', () => {
    const counters = document.querySelector('.counters');
    const rect = counters.getBoundingClientRect();
    if (!started && rect.top < window.innerHeight) {
      animateCounter('vehicles-sold', 10000, 2000);
      animateCounter('experience', 5, 2000);
      started = true;
    }
  });
</script>
</body>
</html>