<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/db.php';
?>

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
<?php include 'a_nav.php'; ?>
<br><br><br><br>

<h2>Book a Test Drive</h2>

<?php
if (!empty($_GET['msg'])) {
  echo '<div class="alert">'.htmlspecialchars($_GET['msg']).'</div>';
}
?>

<form action="submit-booking.php" method="POST" class="form-card">
  <label>Your Name:</label>
  <input type="text" name="name" required>

  <label>Email Address:</label>
  <input type="email" name="email" required>

  <label>Phone Number:</label>
  <input type="tel" name="phone" pattern="07[0-9]{8}" required>

  <label>Vehicle:</label>
  <select name="vehicle_id" required>
    <option value="">-- Select Vehicle --</option>
    <?php
    $vehicles = mysqli_query($conn, "SELECT id, make, model FROM vehicles ORDER BY make, model");
    while ($v = mysqli_fetch_assoc($vehicles)): ?>
        <option value="<?= $v['id'] ?>">
            <?= htmlspecialchars($v['make'].' '.$v['model']) ?>
        </option>
    <?php endwhile; ?>
  </select>

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
            <input type="email" name="newsletter_email" class="form-control" placeholder="Your email" required>
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

<script>
  // Navbar scroll effect
  $(window).scroll(function(){
    if($(this).scrollTop() > 50){
      $('.navbar').addClass('scrolled');
    } else {
      $('.navbar').removeClass('scrolled');
    }
  });
</script>

</body>
</html>
