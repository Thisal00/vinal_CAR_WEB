<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book a Test Drive - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    :root {
      --brand-bg: #0b1e3f;
      --brand-gold: #ffd700;
      --panel: #11182e;
      --text: #f4f4f4;
      --input-bg: #1b2a4a;
      --button-hover: #e6c200;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
      margin: 0;
      padding-top: 70px;
    }

    h2 {
      color: var(--brand-gold);
      text-align: center;
      margin-bottom: 30px;
    }

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); transition: background 0.3s; }
    .navbar.scrolled { background: var(--panel) !important; }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    /* Form Card */
    .form-card {
      max-width: 500px;
      margin: 0 auto 40px auto;
      background: var(--panel);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.5);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .form-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.6); }

    .form-card label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    .form-card input,
    .form-card select,
    .form-card textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 15px;
      border-radius: 8px;
      border: none;
      background: var(--input-bg);
      color: #f4f4f4;
    }

    .form-card button {
      background: var(--brand-gold);
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      color: #0b1c39;
      transition: background 0.3s;
      width: 100%;
    }
    .form-card button:hover { background: var(--button-hover); }

    .alert {
      background: #222d44;
      color: var(--brand-gold);
      padding: 10px 15px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
    }

    /* Footer */
    footer {
      background: #101010;
      padding: 30px 0;
      color: #aaa;
    }
    footer h5 { color: var(--brand-gold); }
    .footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; }
    .footer-link:hover { color: #fff; }
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
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>
  <h2> Book  a test Drive </h2>
<?php
if (!empty($_GET['msg'])) {
  echo '<div class="alert">'.htmlspecialchars($_GET['msg']).'</div>';
}
$vehicle_id = isset($_GET['vehicle_id']) ? intval($_GET['vehicle_id']) : 1;
?>

<form action="submit-booking.php" method="POST" class="form-card">
  <input type="hidden" name="vehicle_id" value="<?= $vehicle_id ?>">

  <label>Your Name:</label>
  <input type="text" name="name" required>

  <label>Email Address:</label>
  <input type="email" name="email" required>

  <label>Phone Number:</label>
  <input type="tel" name="phone" pattern="07[0-9]{8}" required>

  <label>Date:</label>
  <input type="date" name="date" min="<?= date('Y-m-d') ?>" required>

  <label>Time:</label>
  <input type="time" name="time" required>

  <button type="submit">Book Test Drive</button>
</form>

<!-- Social Links -->
<div class="social-links text-center mb-4">
  <a href="https://facebook.com/YourPage" target="_blank"><i class="fab fa-facebook"></i></a>
  <a href="https://instagram.com/YourPage" target="_blank"><i class="fab fa-instagram"></i></a>
  <a href="https://www.tiktok.com/@YourPage" target="_blank"><i class="fab fa-tiktok"></i></a>
  <a href="mailto:info@vinalauto.lk"><i class="fas fa-envelope"></i></a>
</div>

<!-- WhatsApp Button -->
<a href="https://wa.me/94771234567" class="whatsapp-btn" target="_blank"><i class="fab fa-whatsapp"></i></a>

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
        <a href="#" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="#" class="footer-link">About</a>
        <a href="#" class="footer-link">Services</a>
        <a href="#" class="footer-link">Contact</a>
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
        <p class="mb-0">&copy; <?= date('Y'); ?> Vinal Auto Traders. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-right">
        <a href="#" class="footer-link d-inline">Privacy Policy</a>
        <a href="#" class="footer-link d-inline">Terms of Use</a>
        <a href="#" class="footer-link d-inline">Sitemap</a>
      </div>
    </div>
  </div>
</footer>
