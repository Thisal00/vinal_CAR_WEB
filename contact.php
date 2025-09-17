<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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

    
    /* Form */
    form.card {
      background: var(--panel);
      color: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      margin-top: 2rem;
    }
    form.card input, form.card textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1rem;
      border-radius: 6px;
      border: none;
    }
    form.card button {
      background: var(--brand-gold);
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      color: #0b1c39;
    }

    /* Map */
    .map-container {
      width: 100%;
      height: 400px;
      margin-top: 2rem;
      border-radius: 10px;
      overflow: hidden;
    }

    /* Social & WhatsApp */
    .social-links a {
      color: var(--text);
      margin-right: 15px;
      font-size: 1.5rem;
      transition: color 0.3s;
    }
    .social-links a:hover { color: var(--brand-gold); }
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
    }
    .whatsapp-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 12px rgba(0,0,0,0.4);
    }
    .alert {
      background: #222d44;
      color: var(--brand-gold);
      padding: 10px 15px;
      border-radius: 6px;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
  <?php include 'a_nav.php'; ?>

<!-- Main Content -->
<main class="container" style="margin-top:90px; max-width: 900px;">
  <h2>Contact Us</h2>

  <!-- Google Map -->
  <div class="map-container">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31630.123456!2d79.854!3d6.914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259123456789%3A0xabcdef123456789!2sColombo%2C%20Sri%20Lanka!5e0!3m2!1sen!2sus!4v1695980000000" 
      width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>

  <!-- Contact Form -->
  <?php
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $message = trim($_POST['message'] ?? '');
      if ($name && $email && $message) {
        $stmt = $mysqli->prepare("INSERT INTO messages (name,email,message) VALUES (?,?,?)");
        $stmt->bind_param('sss',$name,$email,$message);
        $stmt->execute();
        $stmt->close();
        $msg = ' Thanks! We will get back to you soon.';
      } else {
        $msg = ' Please fill all fields.';
      }
    }
    if ($msg) echo '<div class="alert">'.$msg.'</div>';
  ?>

  <form method="post" class="card form">
    <input type="text" name="name" placeholder="Your name" required>
    <input type="email" name="email" placeholder="Your email" required>
    <textarea name="message" placeholder="Your message" required></textarea>
    <button type="submit">Send</button>
  </form>

  <!-- Social Links -->
  <div class="social-links mt-4 text-center">
    <a href="https://facebook.com/YourPage" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="https://instagram.com/YourPage" target="_blank"><i class="fab fa-instagram"></i></a>
    <a href="https://www.tiktok.com/@YourPage" target="_blank"><i class="fab fa-tiktok"></i></a>
    <a href="mailto:info@vinalauto.lk"><i class="fas fa-envelope"></i></a>
  </div>
</main>

<!-- WhatsApp Button -->
<a href="https://wa.me/94768291088" class="whatsapp-btn" target="_blank"><i class="fab fa-whatsapp"></i></a>
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
</body>
</html>
