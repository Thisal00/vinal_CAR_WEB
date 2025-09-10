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

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

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
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a class="navbar-brand text-warning" href="index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
     <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link" href="book-test-drive.php">Booking</a></li>
      <li class="nav-item"><a class="nav-link" href="parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

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
