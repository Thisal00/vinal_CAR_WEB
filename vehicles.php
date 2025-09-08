<?php require_once __DIR__.'/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vehicles - Vinal Auto</title>

<!-- Bootstrap & Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
:root {
  --brand-bg: #0b1e3f;
  --brand-gold: #ffd700;
  --brand-blue: #2196f3;
  --panel: #11182e;
  --text: #f4f4f4;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: var(--brand-bg);
  color: var(--text);
}

h2 { color: var(--brand-gold); margin-bottom: 20px; }

/* Filters */
form.filters {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px,1fr));
  gap: 10px;
  margin-bottom: 25px;
  padding: 15px;
  background-color: #162b4d;
  border-radius: 8px;
  border: 1px solid #444;
}
form.filters input,
form.filters select {
  padding: 8px;
  border-radius: 6px;
  border: 1px solid #3e5a7d;
  background-color: #0b1e3f;
  color: #fff;
}
form.filters input::placeholder { color: #ccc; }
form.filters .btn {
  background-color: var(--brand-gold);
  color: #111;
  border: none;
}
form.filters .btn:hover { background-color: #fff176; }

/* Vehicle cards */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
}

.card {
  background-color: var(--panel);
  border-radius: 12px;
  border: 1px solid #2c3e50;
  overflow: hidden;
  transition: 0.3s;
  display: flex;
  flex-direction: column;
}

.card:hover {
  box-shadow: 0 6px 16px rgba(255,255,255,0.15);
  transform: translateY(-5px);
}

.card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.card .p-2 { padding: 12px; flex-grow: 1; }
.card h4 { margin: 8px 0; color: var(--brand-gold); font-size: 18px; }
.card .muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }
.card p { font-size: 13px; color: #e0e0e0; flex-grow: 1; }

.card .btn-view {
  background-color: var(--brand-blue);
  color: #fff;
  border: none;
  width: calc(100% - 24px);
  margin: 0 12px 12px 12px;
  border-radius: 6px;
  padding: 6px;
  font-weight: 500;
  font-size: 14px;
  text-align: center;
  text-decoration: none;
  transition: 0.3s;
}
.card .btn-view:hover {
  background-color: #1976d2;
  color: #fff;
  text-decoration: none;
}

/* Footer */
footer {
  background: #010205ff;
  color: #ddd;
  padding: 40px 0 20px;
  margin-top: 50px;
}
footer h5 { color: var(--brand-gold); margin-bottom: 15px; }
footer p, footer a { color: #bbb; font-size: 14px; }
footer a:hover { color: #fff; text-decoration: none; }
.footer-link { display: block; margin-bottom: 5px; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(0,0,0,0.9);">
  <a class="navbar-brand text-warning" href="index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link active" href="vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link" href="parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      <li class="nav-item"><a class="btn btn-warning ms-2" href="admin/login.php">Admin</a></li>
    </ul>
  </div>
</nav>

<!-- Main -->
<main class="container" style="margin-top:100px; max-width:1200px;">
<h2>Vehicles</h2>
awy-sfcw-pzw


