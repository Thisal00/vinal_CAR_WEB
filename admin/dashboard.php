<?php
require_once __DIR__.'/../db.php';
require_login();

// Fetch counts
$counts = [
  'vehicles' => $mysqli->query("SELECT COUNT(*) c FROM vehicles")->fetch_assoc()['c'],
  'reviews' => $mysqli->query("SELECT COUNT(*) c FROM reviews WHERE status='pending'")->fetch_assoc()['c'],
  'messages' => $mysqli->query("SELECT COUNT(*) c FROM messages")->fetch_assoc()['c'],
  'orders'   => $mysqli->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'],
  'parts'    => $mysqli->query("SELECT COUNT(*) c FROM parts")->fetch_assoc()['c'],
  'users'    => $mysqli->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c']
];
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <header class="flex-between">
      <h2>Admin Dashboard</h2>
      <div>Welcome, <?= e($_SESSION['username'] ?? '') ?> | <a class="btn" href="logout.php">Logout</a></div>
    </header>

    <nav class="nav-links">
      <a href="vehicles.php">Vehicles</a>
      <li><a href="parts.php">Parts</a></li>
      <li><a href="orders.php">Orders</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="messages.php">massages</a><
      <li><a href="reviews.php">Reviews</a></li>
    </nav>

    <section class="grid">
      <?php foreach ($counts as $label => $count): ?>
        <div class="card">
          <h3><?= ucfirst($label) ?></h3>
          <p><?= (int)$count ?> total</p>
        </div>
      <?php endforeach; ?>
    </section>

    <section style="margin-top:30px">
      <h3>Monthly Orders</h3>
      <canvas id="ordersChart" style="max-width:600px;"></canvas>
      <?php
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
          $result = $mysqli->query("SELECT COUNT(*) AS total FROM orders WHERE MONTH(order_date) = $i");
          $monthlyData[] = $result->fetch_assoc()['total'];
        }
      ?>
      <script>
        new Chart(document.getElementById('ordersChart'), {
          type: 'bar',
          data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
              label: 'Orders',
              data: <?= json_encode($monthlyData) ?>,
              backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
          }
        });
      </script>
    </section>
  </div>
</body>

</html>