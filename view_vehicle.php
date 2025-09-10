
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vehicle Details - <?= htmlspecialchars($vehicle['make'].' '.$vehicle['model']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

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

.navbar { background: rgba(0,0,0,0.85); }
.navbar-nav .nav-link { color: #fff !important; font-weight: 500; }
.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active { color: var(--brand-gold) !important; }

.vehicle-card {
  background: var(--panel);
  border-radius: 12px;
  padding: 25px;
  margin-top: 90px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  opacity: 0;
  transform: translateY(20px);
  transition: 0.5s;
}

.vehicle-card.show {
  opacity: 1;
  transform: translateY(0);
}

.vehicle-card img.vehicle-img {
  width: 100%;
  height: auto;
  max-height: 500px; /* prevent huge images */
  object-fit: contain;
  border-radius: 12px;
  margin-bottom: 15px;
}

.vehicle-card .btn-book {
  background-color: var(--brand-gold);
  color: #111;
  font-weight: bold;
  border: none;
  padding: 10px 18px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.3s;
  text-decoration: none;
  display: block;
}
.vehicle-card .btn-book:hover { background-color: #fff176; }

.muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }

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
  <a class="navbar-brand text-warning" href="/vinal_auto/index.php">Vinal Auto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/vehicles.php">Vehicles</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/user_parts.php">Parts</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/reviews.php">Reviews</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/about.php">About</a></li>
      <li class="nav-item"><a class="nav-link" href="/vinal_auto/contact.php">Contact</a></li>
    </ul>
  </div>
</nav>
