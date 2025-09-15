<?php
// Start session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to mark active page
function isActive($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $currentPage === $page ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vinal Auto Traders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-bg: #0b1e3f;
      --brand-gold: #ffd700;
      --navbar-h: 56px;
    }
    /* Vehicle cards background fix */
.vehicle-card {
  background-color: #0a1a2f !important; /* Dark Blue */
  color: #0a0037ff !important;               /* White text */
  border-radius: 10px;
  padding: 15px;
  margin: 10px 0;
}


    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--brand-bg);
      color: #fff;
    }

    /* Navbar styles */
    .navbar {
      background: rgba(0,0,0,0.7);
      padding: 0.5rem 1rem;
    }

    .navbar-brand {
      color: var(--brand-gold) !important;
      font-weight: 700;
      font-size: 1.4rem;
    }

    .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 500;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--brand-gold) !important;
    }

    .btn-warning {
      font-weight: 600;
    }

    @media (max-width: 992px) {
      .navbar-nav {
        background-color: rgba(0,0,0,0.85);
        padding: 10px;
        border-radius: 8px;
      }
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <a class="navbar-brand" href="index.php">Vinal Auto</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link <?= isActive('index.php') ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('vehicles.php') ?>" href="vehicles.php">Vehicles</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('parts.php') ?>" href="parts.php">Parts</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('book-test-drive.php') ?>" href="book-test-drive.php">Booking</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('reviews.php') ?>" href="reviews.php">Reviews</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('about.php') ?>" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link <?= isActive('contact.php') ?>" href="contact.php">Contact</a></li>
        <li class="nav-item">
          <a class="btn btn-warning ms-2" href="admin/login.php">Admin</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Bootstrap JS + dependencies -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
