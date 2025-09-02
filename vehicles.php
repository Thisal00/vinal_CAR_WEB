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
      --panel: #11182e;
      --text: #f4f4f4;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--brand-bg);
      color: var(--text);
    }
    h2 { color: var(--brand-gold); }

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
    }
    .card:hover {
      box-shadow: 0 6px 16px rgba(255,255,255,0.1);
      transform: translateY(-5px);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .card .p-2 { padding: 12px; }
    .card h4 { margin: 8px 0; color: var(--brand-gold); }
    .card .muted { color: #ccc; font-size: 14px; margin-bottom: 5px; }
    .card p { font-size: 13px; color: #e0e0e0; }
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
      <li class="nav-item"><a class="nav-link active " href="vehicles.php">Vehicles</a></li>
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

  <!-- Filters -->
  <form class="filters" method="get">
    <input type="text" name="q" placeholder="Make or Model" value="<?php echo e($_GET['q'] ?? ''); ?>">
    <input type="number" name="min_price" placeholder="Min Price" value="<?php echo e($_GET['min_price'] ?? ''); ?>">
    <input type="number" name="max_price" placeholder="Max Price" value="<?php echo e($_GET['max_price'] ?? ''); ?>">
    <input type="number" name="year_min" placeholder="Min Year" value="<?php echo e($_GET['year_min'] ?? ''); ?>">
    <input type="number" name="year_max" placeholder="Max Year" value="<?php echo e($_GET['year_max'] ?? ''); ?>">
    <select name="fuel">
      <option value="">Fuel</option>
      <?php
        $fuels = ['Petrol','Diesel','Hybrid','Electric'];
        $sel = $_GET['fuel'] ?? '';
        foreach ($fuels as $f) {
          $s = ($sel===$f)?'selected':''; echo "<option $s>".e($f)."</option>";
        }
      ?>
    </select>
    <select name="transmission">
      <option value="">Transmission</option>
      <?php
        $trs = ['Manual','Automatic'];
        $sel = $_GET['transmission'] ?? '';
        foreach ($trs as $t) {
          $s = ($sel===$t)?'selected':''; echo "<option $s>".e($t)."</option>";
        }
      ?>
    </select>
    <button class="btn">Filter</button>
  </form>

  <!-- Vehicle Grid -->
  <div class="grid">
  <?php
    $where=[]; $params=[]; $types='';
    if (!empty($_GET['q'])) { $where[]="(make LIKE CONCAT('%', ?, '%') OR model LIKE CONCAT('%', ?, '%'))"; $params[]=$_GET['q']; $params[]=$_GET['q']; $types.='ss'; }
    if (!empty($_GET['min_price'])) { $where[]="price >= ?"; $params[]=$_GET['min_price']; $types.='d'; }
    if (!empty($_GET['max_price'])) { $where[]="price <= ?"; $params[]=$_GET['max_price']; $types.='d'; }
    if (!empty($_GET['year_min'])) { $where[]="year >= ?"; $params[]=$_GET['year_min']; $types.='i'; }
    if (!empty($_GET['year_max'])) { $where[]="year <= ?"; $params[]=$_GET['year_max']; $types.='i'; }
    if (!empty($_GET['fuel'])) { $where[]="fuel = ?"; $params[]=$_GET['fuel']; $types.='s'; }
    if (!empty($_GET['transmission'])) { $where[]="transmission = ?"; $params[]=$_GET['transmission']; $types.='s'; }

    $sql="SELECT id, make, model, year, price, mileage, transmission, fuel, description, image FROM vehicles ";
    if ($where) { $sql .= " WHERE ".implode(" AND ", $where); }
    $sql .= " ORDER BY id DESC";

    $stmt=$mysqli->prepare($sql);
    if ($params) { $stmt->bind_param($types, ...$params); }
    $stmt->execute(); $res=$stmt->get_result();
    while ($row=$res->fetch_assoc()) {
      $img = $row['image'] ? 'assets/images/uploads/'.e($row['image']) : 'assets/images/no-car.png';
      echo '<div class="card">';
      echo '  <img src="'.e($img).'" alt="Vehicle">';
      echo '  <div class="p-2">';
      echo '    <h4>'.e($row['year']).' '.e($row['make']).' '.e($row['model']).'</h4>';
      echo '    <div class="muted">LKR '.number_format((float)$row['price'], 2).'</div>';
      echo '    <div class="muted">'.e($row['fuel']).' • '.e($row['transmission']).' • '.number_format((float)$row['mileage']).' km</div>';
      echo '    <p>'.e($row['description']).'</p>';
      echo '  </div>';
      echo '</div>';
    }
    $stmt->close();
  ?>
  </div>
</main>

<!-- Footer -->
<footer class="text-light" style="background:#101010; padding:30px 0; margin-top:40px;">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h5 class="text-warning">Contact Us</h5>
        <p>123 Car Street, Colombo<br>Phone: +94 77 123 4567<br>Email: info@vinalauto.lk</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="text-warning">Quick Links</h5>
        <a href="index.php" class="d-block text-light">Home</a>
        <a href="vehicles.php" class="d-block text-light">Vehicles</a>
        <a href="about.php" class="d-block text-light">About</a>
        <a href="contact.php" class="d-block text-light">Contact</a>
      </div>
      <div class="col-md-4 mb-4">
        <h5 class="text-warning">Newsletter</h5>
        <form>
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Your email" required>
            <div class="input-group-append">
              <button class="btn btn-warning">Subscribe</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <hr style="border-color: rgba(255,255,255,0.1)">
    <div class="row">
      <div class="col-md-6">&copy; <?php echo date('Y'); ?> Vinal Auto Traders</div>
      <div class="col-md-6 text-right">
        <a href="#" class="text-light">Privacy Policy</a> |
        <a href="#" class="text-light">Terms of Use</a>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
