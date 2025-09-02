<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Vinal Auto Traders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <!-- Animate.css for subtle hero animations -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

  <style>
    /* Base */
    :root {
      --brand-bg: #0b1e3f;
      --brand-gold: #ffd700;
      --panel: #11182e;
      --text: #f4f4f4;
      --muted: #c7c7c7;
      --shadow: rgba(0,0,0,0.45);
      --navbar-h: 56px; /* default bootstrap fixed-top height */
    }
    html, body {
      height: 100%;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
      margin: 0;
    }
    h1, h2, h3, h5 { color: var(--brand-gold); font-weight: 700; }

    /* Navbar (unchanged theme) */
    .navbar { background: rgba(0,0,0,0.7); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover { color: var(--brand-gold) !important; }

    /* Hero: video directly under navbar */
    .hero-section {
      position: relative;
      margin-top: var(--navbar-h);
      height: calc(100vh - var(--navbar-h));
      min-height: 520px;
      overflow: hidden;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .hero-video {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      filter: brightness(0.65) saturate(1.05);
      z-index: -2;
    }
    .hero-gradient {
      position: absolute; inset: 0;
      background: radial-gradient(60% 60% at 50% 40%, rgba(0,0,0,0) 0%, rgba(0,0,0,0.35) 55%, rgba(0,0,0,0.6) 100%);
      z-index: -1;
    }
    .hero-overlay {
      height: 100%;
      padding: 0 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero-inner {
      max-width: 980px;
      width: 100%;
    }
    .hero-title { letter-spacing: 0.3px; }
    .hero-sub {
      color: #e9e9e9;
      font-weight: 300;
    }
    .hero-cta {
      box-shadow: 0 10px 25px var(--shadow);
    }
    .hero-highlights .card {
      background: rgba(17,24,46,0.7);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 14px;
      backdrop-filter: blur(2px);
      transition: transform .25s ease, box-shadow .25s ease;
      height: 100%;
    }
    .hero-highlights .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.5);
    }
    .scroll-down {
      position: absolute; bottom: 18px; left: 50%;
      transform: translateX(-50%);
      color: var(--muted);
      font-size: 0.9rem;
      display: flex; flex-direction: column; align-items: center;
      opacity: 0.9;
    }
    .scroll-down .mouse {
      width: 24px; height: 38px;
      border: 2px solid var(--muted);
      border-radius: 16px;
      position: relative;
      margin-bottom: 6px;
    }
    .scroll-down .mouse::after {
      content: "";
      width: 3px; height: 8px;
      background: var(--muted);
      border-radius: 2px;
      position: absolute; top: 6px; left: 50%;
      transform: translateX(-50%);
      animation: wheel 1.4s infinite;
    }
    @keyframes wheel {
      0% { opacity: 0; transform: translate(-50%,0); }
      40% { opacity: 1; }
      100% { opacity: 0; transform: translate(-50%,12px); }
    }

    /* Sections */
    .section {
      padding: 60px 0;
    }
    .panel {
      background: var(--panel);
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.35);
    }

    /* Scrolling brand strip */
    .scroll-img {
      white-space: nowrap;
      overflow: hidden;
      mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
      -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
      padding: 10px 0;
      position: relative;
    }
    .scroll-track {
      display: inline-block;
      white-space: nowrap;
      animation: marquee 18s linear infinite;
    }
    .scroll-img:hover .scroll-track { animation-play-state: paused; }
    .scroll-img img {
      height: 70px; margin: 0 30px; display: inline-block;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.35));
    }
    @keyframes marquee {
      from { transform: translateX(0); }
      to   { transform: translateX(-50%); }
    }

    /* Vehicle slider */
    .slider-container { position: relative; overflow: hidden; }
    .vehicle-slider {
      display: flex; gap: 20px; padding: 20px 4px;
      overflow-x: auto; scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
      mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
      -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }
    .vehicle-slider img {
      max-height: 220px; border-radius: 12px;
      transition: transform .3s, box-shadow .3s;
      scroll-snap-align: center;
    }
    .vehicle-slider img:hover {
      transform: scale(1.06);
      box-shadow: 0 14px 28px rgba(0,0,0,0.45);
    }
    .slide-arrow {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: rgba(0,0,0,0.5); border: none;
      color: var(--brand-gold);
      padding: 10px 12px; cursor: pointer; z-index: 2;
      border-radius: 10px;
      transition: background .2s ease;
    }
    .slide-arrow:hover { background: rgba(0,0,0,0.65); }
    .slide-arrow.left { left: 8px; }
    .slide-arrow.right { right: 8px; }

    /* Calculator */
    .calc-box { background: var(--panel); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.4); }

    /* WhatsApp Button */
    .whatsapp-float {
      position: fixed; bottom: 20px; right: 20px;
      background: #25d366; color: #fff; border-radius: 50%;
      width: 60px; height: 60px; display: flex; justify-content: center; align-items: center;
      font-size: 28px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); z-index: 1000;
    }
    .whatsapp-float:hover { background: #1ebe57; color: #fff; }

    /* Footer */
    footer { background: #101010; padding: 30px 0; color: #aaa; margin-top: 40px; }
  </style>
</head>
<body>

  <!-- Navbar (unchanged) -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <a class="navbar-brand text-warning" href="#">Vinal Auto</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link" href="parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link " href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
    </div>
  </nav>

  <!-- HERO: Video directly under navbar -->
  <header class="hero-section">
    <video class="hero-video" autoplay muted loop playsinline>
      <source src="assets/videos/hh.mp4" type="video/mp4" />
    </video>
    <div class="hero-gradient"></div>

    <div class="hero-overlay">
      <div class="hero-inner">
        <h1 class="hero-title display-4 text-warning mb-3 animate__animated animate__fadeInDown">
          Welcome to Vinal Auto Traders
        </h1>
        <p class="hero-sub lead mb-4 animate__animated animate__fadeInUp">
          Find your dream ride with trusted dealers  from sleek city cars to rugged offroaders,
          we bring you the best deals in Sri Lanka.
        </p>
        <a href="vehicles.php" class="btn btn-warning btn-lg hero-cta mb-4 animate__animated animate__pulse animate__infinite">
          Browse Vehicles
        </a>

        <!-- Highlights -->
        <div class="hero-highlights mt-2">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                  <i class="fas fa-car-side text-warning mr-2"></i>
                  <h5 class="mb-0">Wide Selection</h5>
                </div>
                <p class="mb-0" style="color:#ddd;">Hatchbacks, sedans, SUVs, and pickups — curated listings that fit your lifestyle and budget.</p>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                  <i class="fas fa-shield-alt text-warning mr-2"></i>
                  <h5 class="mb-0">Trusted Dealers</h5>
                </div>
                <p class="mb-0" style="color:#ddd;">Verified partners, transparent pricing, and assistance from inquiry to handover.</p>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card p-3 h-100">
                <div class="d-flex align-items-center mb-2">
                  <i class="fas fa-percentage text-warning mr-2"></i>
                  <h5 class="mb-0">Smart Financing</h5>
                </div>
                <p class="mb-0" style="color:#ddd;">Easy monthly plans with our banking partners and a quick payment estimate below.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Scroll cue -->
        <a href="#content" class="scroll-down">
          <span class="mouse"></span>
          <span>Scroll</span>
        </a>
      </div>
    </div>
  </header>

  <main id="content">
    <!-- About -->
    <section class="section">
      <div class="container text-center">
        <h2>About Our Company</h2>
        <p class="mx-auto" style="max-width: 820px;">
          We are Sri Lanka’s leading automobile marketplace, connecting buyers and trusted dealers with a smooth,
          secure experience. Explore brand-new and quality used vehicles with confidence, transparent pricing,
          and personalized guidance.
        </p>
      </div>
    </section>

    <!-- Banner -->
    <section class="section pt-0">
      <div class="container">
        <img src="assets/images/banner.jpg" class="img-fluid rounded shadow-lg w-100" alt="Showroom banner" loading="lazy">
      </div>
    </section>

    <!-- Brand marquee -->
    <section class="section pt-4 pb-0">
      <div class="container">
        <div class="scroll-img">
          <!-- wrapper -->
<div class="scroll-wrapper">
  <!-- track (contains duplicate images for seamless loop) -->
<div class="scroll-track">
            <img src="assets/brands/honda.png" alt="Honda" loading="lazy">
            <img src="assets/brands/isuzu.png" alt="Isuzu" loading="lazy">
            <img src="assets/brands/landrover.png" alt="Land Rover" loading="lazy">
            <img src="assets/brands/mg.png" alt="MG" loading="lazy">
            <img src="assets/brands/mitsubishi.png" alt="Mitsubishi" loading="lazy">
            <!-- repeat -->
            <img src="assets/brands/honda.png" alt="Honda" loading="lazy">
            <img src="assets/brands/isuzu.png" alt="Isuzu" loading="lazy">
            <img src="assets/brands/landrover.png" alt="Land Rover" loading="lazy">
            <img src="assets/brands/mg.png" alt="MG" loading="lazy">
            <img src="assets/brands/mitsubishi.png" alt="Mitsubishi" loading="lazy">
          </div>


  </div>
</div>

        </div>
      </div>
    </section>

    <!-- Calculator -->
    <section class="section pt-4">
      <div class="container">
        <div class="calc-box panel">
          <h3 class="mb-3">Finance Calculator</h3>
          <form id="calcForm">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Amount (LKR)</label>
                <input type="number" id="amount" class="form-control" placeholder="e.g. 5,500,000">
              </div>
              <div class="form-group col-md-3">
                <label>Down Payment (LKR)</label>
                <input type="number" id="down" class="form-control" placeholder="e.g. 1,000,000">
              </div>
              <div class="form-group col-md-3">
                <label>Interest Rate (%)</label>
                <input type="number" id="rate" class="form-control" placeholder="e.g. 12">
              </div>
              <div class="form-group col-md-3">
                <label>Loan Term (Months)</label>
                <input type="number" id="term" class="form-control" placeholder="e.g. 60">
              </div>
            </div>
            <button type="button" class="btn btn-warning" onclick="calculate()">Calculate</button>
            <button type="reset" class="btn btn-light ml-2" onclick="resetCalc()">Reset</button>
            <div class="mt-3">
              <h5>Monthly Payment: <span id="monthly">0</span> LKR</h5>
              <small class="text-muted">Estimate only. Actual figures depend on bank evaluation.</small>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Banks ticker -->
<section class="section pt-2 pb-0">
  <div class="container">
    <div class="scroll-panel">
      <div class="scroll-track">
        <div class="scroll-item">
          <img src="images/sey.png" alt="Seylan" class="bank-logo"> Seylan
        </div>
        <div class="scroll-item">
          <img src="images/hnbl.png" alt="HNB" class="bank-logo"> HNB
        </div>
        <div class="scroll-item">
          <img src="images/lbf.png" alt="LB Finance" class="bank-logo"> LB Finance
        </div>
        <div class="scroll-item">
          <img src="images/siy.png" alt="Siyapatha" class="bank-logo"> Siyapatha
        </div>
        <!-- Repeat for seamless effect -->
        <div class="scroll-item">
          <img src="images/sey.png" alt="Seylan" class="bank-logo"> Seylan
        </div>
        <div class="scroll-item">
          <img src="images/hnbl.png" alt="HNB" class="bank-logo"> HNB
        </div>
        <div class="scroll-item">
          <img src="images/lbf.png" alt="LB Finance" class="bank-logo"> LB Finance
        </div>
        <div class="scroll-item">
          <img src="images/siy.png" alt="Siyapatha" class="bank-logo"> Siyapatha
        </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.scroll-panel {
  overflow: hidden;
  white-space: nowrap;
  background: #f8f9fa;
  border-radius: 6px;
  padding: 10px 0;
}

.scroll-track {
  display: inline-flex;
  animation: scroll-left 20s linear infinite;
}

.scroll-item {
  display: inline-flex;
  align-items: center;
  margin-right: 50px; /* space between items */
  font-family: "Segoe UI", Roboto, sans-serif;
  font-weight: 600;
  font-size: 1rem;
  color: #0f66d0;
}

.bank-logo {
  height: 30px;
  width: auto;
  margin-right: 8px;
}

@keyframes scroll-left {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-50%); } /* adjust if repeating items */
}
</style>



    <!-- Promo -->
    <section class="section pt-4">
      <div class="container">
        <img src="assets/images/promo.png" class="img-fluid rounded shadow-lg w-100" alt="Promotional offer" loading="lazy">
      </div>
    </section>

    <!-- Vehicles -->
    <section class="section pt-2">
      <div class="container">
        <h3 class="text-center mb-3">Latest Vehicles</h3>
        <div class="slider-container">
          <button class="slide-arrow left" aria-label="Previous">&#8249;</button>
          <div class="vehicle-slider" id="vehicleSlider">
            <img src="assets/images/vehicle1.jpg" alt="Vehicle 1" loading="lazy">
            <img src="assets/images/vehicle2.jpg" alt="Vehicle 2" loading="lazy">
            <img src="assets/images/vehicle3.jpg" alt="Vehicle 3" loading="lazy">
            <img src="assets/images/vehicle4.jpg" alt="Vehicle 4" loading="lazy">
          </div>
          <button class="slide-arrow right" aria-label="Next">&#8250;</button>
        </div>
        <div class="text-center mt-3">
          <a href="vehicles.php" class="btn btn-outline-warning">See All Vehicles</a>
        </div>
      </div>
    </section>

    <!-- Agents + Future -->
    <section class="section">
      <div class="container text-center">
        <h3>Our Authorized Agents</h3>
        <p class="brand-text">
  We offer brand new vehicles from our trusted agents of 
  <strong>Toyota</strong>, <strong>Mazda</strong>, <strong>Subaru</strong>, 
  and <strong>Suzuki Japan</strong>. Every vehicle comes with guaranteed 
  quality and excellent service support.
</p>

<style>
  .brand-text {
    font-family: "Segoe UI", Roboto, Arial, sans-serif; /* clean modern font */
    font-size: 1.2rem;      /* good readable size */
    line-height: 1.8;       /* spacing between lines */
    color: #b0b0adaa;         /* dark blue-gray for professional look */
    text-align: center;     /* center text for nice UI */
    max-width: 900px;       /* keep it readable on big screens */
    margin: 20px auto;      /* spacing around */
  }
  .brand-text strong {
    color: #b8a953cb;         /* highlight brand names in blue */
  }
</style>

        <img src="assets/images/agents.png" class="img-fluid rounded shadow-lg mb-4" alt="Authorized agents" loading="lazy">
        <h3>Our Future</h3>
        <p class="mx-auto" style="max-width: 12000px;">
          Growing across Sri Lanka with more showrooms, seamless digital buying, and simplified financing — so you can
          choose, compare, and drive away faster.
        </p>
      </div>
    </section>
  </main>

  <!-- WhatsApp -->
  <a href="https://wa.me/94771234567" class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>

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
            <?php if ($newsletter_msg): ?>
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





  <!-- Scripts -->
  <script src="https://kit.fontawesome.com/a2e0e6ad5a.js" crossorigin="anonymous"></script>
  <script>
    // Finance Calculator
    function calculate() {
      const amt = parseFloat(document.getElementById('amount').value) || 0;
      const down = parseFloat(document.getElementById('down').value) || 0;
      const rate = parseFloat(document.getElementById('rate').value) || 0;
      const term = Math.max(1, parseFloat(document.getElementById('term').value) || 1);

      const loan = Math.max(0, amt - down);
      const mRate = rate / 100 / 12;

      let payment = 0;
      if (mRate === 0) {
        payment = loan / term;
      } else {
        payment = (loan * mRate) / (1 - Math.pow(1 + mRate, -term));
      }
      document.getElementById('monthly').innerText = isFinite(payment) ? Math.round(payment).toLocaleString() : '0';
    }
    function resetCalc() {
      document.getElementById('monthly').innerText = '0';
    }

    // Vehicle slider arrows
    const slider = document.getElementById('vehicleSlider');
    const leftBtn = document.querySelector('.slide-arrow.left');
    const rightBtn = document.querySelector('.slide-arrow.right');

    if (leftBtn && rightBtn && slider) {
      leftBtn.addEventListener('click', () => slider.scrollBy({ left: -320, behavior: 'smooth' }));
      rightBtn.addEventListener('click', () => slider.scrollBy({ left: 320, behavior: 'smooth' }));
    }
  </script>
</body>
</html>