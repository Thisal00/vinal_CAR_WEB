<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db.php';

// Escape helper if not already declared
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

// --- Dashboard Counts (for cards) ---
$counts = [];
$tables = ['vehicles', 'parts', 'orders', 'users', 'messages', 'reviews'];
foreach ($tables as $table) {
    $result = $mysqli->query("SELECT COUNT(*) AS total FROM $table");
    $counts[$table] = $result->fetch_assoc()['total'];
}

// --- Monthly Orders (for chart) ---
$monthlyData = [];
for ($i = 1; $i <= 12; $i++) {
    $stmt = $mysqli->prepare("
        SELECT COUNT(*) AS total 
        FROM orders 
        WHERE MONTH(created_at) = ? AND YEAR(created_at) = YEAR(CURDATE())
    ");
    $stmt->bind_param("i", $i);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    $monthlyData[] = $res['total'];
}

// --- Weekly Orders (last 7 days) ---
$weeklyLabels = [];
$weeklyData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date("Y-m-d", strtotime("-$i days"));
    $weeklyLabels[] = date("D", strtotime($date)); // Mon, Tue, etc.
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total FROM orders WHERE DATE(created_at) = ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $weeklyData[] = $res['total'];
}

// --- Today's Orders (list) ---
$todayOrders = $mysqli->query("
    SELECT id, customer_name, total_amount, created_at 
    FROM orders 
    WHERE DATE(created_at) = CURDATE()
    ORDER BY created_at DESC
    LIMIT 10
")->fetch_all(MYSQLI_ASSOC);
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
      <div>
        Welcome, <?= e($_SESSION['username'] ?? '') ?> | 
        <a class="btn" href="logout.php">Logout</a>
      </div>
    </header>

    <nav class="nav-links">
         
        <a href="vehicles.php">Vehicles</a>
        <a href="parts.php">Parts</a>
        <a href="part_messages.php">Orders</a>
        <a href="users.php">Users</a>
        <a href="messages.php">Messages</a>
        <a href="reviews.php">Reviews</a>
        <a href="bookings.php" >Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>

    <!-- Dashboard Cards -->
    <section class="grid">
      <?php foreach ($counts as $label => $count): ?>
        <div class="card">
          <h3><?= ucfirst($label) ?></h3>
          <p><?= (int)$count ?> total</p>
        </div>
      <?php endforeach; ?>
    </section>

    <!-- Charts -->
    <section style="margin-top:30px; display:flex; gap:40px; flex-wrap:wrap;">
      <div style="flex:1; min-width:300px;">
        <h3>Monthly Orders (<?= date("Y") ?>)</h3>
        <canvas id="ordersChart"></canvas>
      </div>

      <div style="flex:1; min-width:300px;">
        <h3>Last 7 Days Orders</h3>
        <canvas id="weeklyChart"></canvas>
      </div>
    </section>

    <!-- Today's Orders -->
    <section style="margin-top:30px">
      <h3>Today's Orders</h3>
      <?php if ($todayOrders): ?>
        <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse;">
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Time</th>
          </tr>
          <?php foreach ($todayOrders as $order): ?>
            <tr>
              <td><?= e($order['id']) ?></td>
              <td><?= e($order['customer_name']) ?></td>
              <td>$<?= e(number_format($order['total_amount'], 2)) ?></td>
              <td><?= e(date("H:i", strtotime($order['created_at']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
        <p>No orders today.</p>
      <?php endif; ?>
    </section>
  </div>

  <script>
    // Monthly Orders Chart
    new Chart(document.getElementById('ordersChart'), {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
          label: 'Orders',
          data: <?= json_encode($monthlyData) ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
      },
      options: { responsive:true, plugins:{legend:{display:false}} }
    });

    // Weekly Orders Chart
    new Chart(document.getElementById('weeklyChart'), {
      type: 'line',
      data: {
        labels: <?= json_encode($weeklyLabels) ?>,
        datasets: [{
          label: 'Orders',
          data: <?= json_encode($weeklyData) ?>,
          borderColor: 'rgba(255, 99, 132, 0.8)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          fill: true,
          tension: 0.3
        }]
      },
      options: { responsive:true, plugins:{legend:{display:false}} }
    });
  </script>
</body>
</html>
