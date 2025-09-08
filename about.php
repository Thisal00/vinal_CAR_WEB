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

