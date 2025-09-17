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
  --text: #fff;
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

/* Strong card colors to prevent navbar interference */
.vehicle-card {
  background-color: var(--panel) !important;
  color: var(--text) !important;
  border-radius: 12px;
  border: 1px solid #2c3e50;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
}

.vehicle-card:hover {
  box-shadow: 0 6px 16px rgba(255,255,255,0.15);
  transform: translateY(-5px);
}

.vehicle-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.vehicle-card .p-2 {
  padding: 12px;
  flex-grow: 1;
}

.vehicle-card h4 {
  margin: 8px 0;
  color: var(--brand-gold) !important;
  font-size: 18px;
}

.vehicle-card .muted {
  color: #ccc !important;
  font-size: 14px;
  margin-bottom: 5px;
}

/* Short description */
.vehicle-card p {
  font-size: 13px;
  color: #e0e0e0 !important;
  flex-grow: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Button inside card */
.vehicle-card .btn-view {
  background-color: var(--brand-blue) !important;
  color: #fff !important;
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
.vehicle-card .btn-view:hover {
  background-color: #1976d2 !important;
  color: #fff !important;
  text-decoration: none;
}

/* Prevent navbar active inheritance */
body .active {
  color: inherit !important;
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
<?php include 'a_nav.php'; ?> 

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

$limit = 9;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$sqlCount = "SELECT COUNT(*) FROM vehicles".($where ? " WHERE ".implode(" AND ", $where) : "");
$stmtCount = $mysqli->prepare($sqlCount);
if ($params) { $stmtCount->bind_param($types, ...$params); }
$stmtCount->execute();
$stmtCount->bind_result($totalRows);
$stmtCount->fetch();
$stmtCount->close();
$totalPages = ceil($totalRows / $limit);

$sql="SELECT id, make, model, year, price, mileage, transmission, fuel, description, image FROM vehicles ";
if ($where) { $sql .= " WHERE ".implode(" AND ", $where); }
$sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

$stmt=$mysqli->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute(); $res=$stmt->get_result();
while ($row=$res->fetch_assoc()) {
  $img = $row['image'] ? 'assets/images/uploads/'.e($row['image']) : 'assets/images/no-car.png';
  echo '<div class="card vehicle-card">';
  echo '  <img src="'.e($img).'" alt="Vehicle">';
  echo '  <div class="p-2">';
  echo '    <h4>'.e($row['year']).' '.e($row['make']).' '.e($row['model']).'</h4>';
  echo '    <div class="muted">LKR '.number_format((float)$row['price'], 2).'</div>';
  echo '    <div class="muted">'.e($row['fuel']).' • '.e($row['transmission']).' • '.number_format((float)$row['mileage']).' km</div>';
  echo '    <p>'.e($row['description']).'</p>';
  echo '  </div>';
  echo '  <a href="view_vehicle.php?id='.e($row['id']).'" class="btn-view">View Details</a>';
  echo '</div>';
}
$stmt->close();
?>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<nav aria-label="Page navigation" class="mt-4">
  <ul class="pagination justify-content-center">
    <li class="page-item <?= ($page<=1)?'disabled':'' ?>">
      <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET,['page'=>$page-1])); ?>">&laquo;</a>
    </li>
    <?php
    $range = 2;
    for ($i = max(1,$page-$range); $i <= min($totalPages,$page+$range); $i++): ?>
      <li class="page-item <?= ($i==$page)?'active':'' ?>">
        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET,['page'=>$i])); ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>
    <?php if ($page+$range < $totalPages): ?>
      <li class="page-item disabled"><span class="page-link">...</span></li>
      <li class="page-item"><a class="page-link" href="?<?php echo http_build_query(array_merge($_GET,['page'=>$totalPages])); ?>"><?php echo $totalPages; ?></a></li>
    <?php endif; ?>
    <li class="page-item <?= ($page>=$totalPages)?'disabled':'' ?>">
      <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET,['page'=>$page+1])); ?>">&raquo;</a>
    </li>
  </ul>
</nav>
<?php endif; ?>

</main>

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
        <a href="index.php" class="footer-link">Home</a>
        <a href="vehicles.php" class="footer-link">Vehicles</a>
        <a href="parts.php" class="footer-link">Parts</a>
        <a href="book-test-drive.php" class="footer-link">Booking</a>
        <a href="reviews.php" class="footer-link">Reviews</a>
        <a href="about.php" class="footer-link">About</a>
        <a href="contact.php" class="footer-link">Contact</a>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Newsletter</h5>
        <p>Get the latest deals straight to your inbox.</p>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
