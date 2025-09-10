<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reviews - Vinal Auto</title>
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
      --card-hover: #1b2a58;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
      scroll-behavior: smooth;
    }

    h2, h3 { color: var(--brand-gold); }

    /* Navbar */
    .navbar { background: rgba(0,0,0,0.85); transition: background 0.3s; }
    .navbar.scrolled { background: var(--panel) !important; }
    .navbar-nav .nav-link { color: #fff !important; font-weight: 500; transition: color 0.3s; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

    /* Review Cards */
    .review-card {
      background: var(--panel);
      padding: 1.5rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      opacity: 0;
      transform: translateY(30px);
      animation: slideUp 0.6s forwards;
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    }
    .review-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      background: var(--card-hover);
    }
    @keyframes slideUp {
      to { opacity: 1; transform: translateY(0); }
    }

    .review-head { display: flex; justify-content: space-between; font-weight: 600; margin-bottom: 0.5rem; }
    .review-head .stars { color: var(--brand-gold); font-size: 1rem; }

    .review-card .stars i {
      opacity: 0;
      transform: scale(0.5);
      display: inline-block;
      animation: starPop 0.4s forwards;
    }
    .review-card .stars i:nth-child(1) { animation-delay: 0.1s; }
    .review-card .stars i:nth-child(2) { animation-delay: 0.2s; }
    .review-card .stars i:nth-child(3) { animation-delay: 0.3s; }
    .review-card .stars i:nth-child(4) { animation-delay: 0.4s; }
    .review-card .stars i:nth-child(5) { animation-delay: 0.5s; }

    @keyframes starPop {
      to { opacity: 1; transform: scale(1); }
    }

    .muted { color: #bbb; font-size: 0.85rem; }

    /* Review Form */
    form.card {
      background: var(--panel);
      color: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      margin-top: 2rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      transition: transform 0.3s;
    }
    form.card:hover { transform: scale(1.01); }
    form.card input, form.card textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      border: none;
      background: #1b2a4a;
      color: #f4f4f4;
    }
    form.card button {
      background: var(--brand-gold);
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      color: #0b1c39;
      transition: background 0.3s;
    }
    form.card button:hover { background: #e6c200; }

    /* Star Rating in form */
    .star-rating i {
      font-size: 1.5rem;
      color: #ccc;
      cursor: pointer;
      transition: color 0.3s, transform 0.2s;
      margin-right: 5px;
    }
    .star-rating i.hovered,
    .star-rating i.selected {
      color: var(--brand-gold);
      transform: scale(1.2);
    }

    /* Alerts */
    .alert {
      background: #222d44;
      color: var(--brand-gold);
      padding: 10px 15px;
      border-radius: 6px;
      margin-top: 1rem;
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }

    /* Footer */
    footer {
      background: #101010;
      padding: 30px 0;
      color: #aaa;
      margin-top: 40px;
    }
    footer h5 { color: var(--brand-gold); }
    .footer-link { display: block; color: #bbb; margin-bottom: 6px; text-decoration: none; transition: color 0.3s; }
    .footer-link:hover { color: #fff; }

    /* Social Links */
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

