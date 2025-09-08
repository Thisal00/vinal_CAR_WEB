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

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

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
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

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

