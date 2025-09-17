<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';

// Escape helper
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

// Success message
$success = $_GET['success'] ?? '';

// Fetch bookings
$result = mysqli_query($conn, "
  SELECT b.*, CONCAT(v.make, ' ', v.model) AS vehicle_name
  FROM test_drive_bookings b
  JOIN vehicles v ON b.vehicle_id = v.id
  ORDER BY b.time
") or die("Query failed: " . mysqli_error($conn));

// Count bookings by status
$statusResult = mysqli_query($conn, "
  SELECT status, COUNT(*) as count 
  FROM test_drive_bookings 
  GROUP BY status
");
$statuses = [];
$counts = [];
while ($row = mysqli_fetch_assoc($statusResult)) {
    $statuses[] = $row['status'];
    $counts[] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Test Drive Bookings</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
    .btn-update {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }
    .btn-update:hover { opacity: 0.9; }
    table select { padding: 4px; }
    table { width: 100%; border-collapse: collapse; }
    table th, table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    .success { color: green; }
</style>
</head>
<body>
<div class="container">
    <header class="flex-between">
        <h2>Manage Test Drive Bookings</h2>
        <div>
            Welcome, <?= e($_SESSION['username'] ?? '') ?> |
            <a class="btn" href="dashboard.php">Back to Dashboard</a> |
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
        <a href="bookings.php" class="active">Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>

    <section style="margin-top:20px">
        <?php if ($success): ?>
            <p class="success">✅ Booking status updated successfully!</p>
        <?php endif; ?>

        <h3>Bookings List</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Vehicle</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): 
                $datetime = strtotime($row['time']);
                $date = date('Y-m-d', $datetime);
                $time = date('H:i', $datetime);
            ?>
            <tr>
                <td><?= e($row['name']) ?></td>
                <td><?= e($row['email']) ?></td>
                <td><?= e($row['phone']) ?></td>
                <td><?= e($row['vehicle_name']) ?></td>
                <td><?= $date ?></td>
                <td><?= $time ?></td>
                <td><?= e($row['status']) ?></td>
                <td>
                    <!-- Form now points to status.php -->
                    <form method="POST" action="status.php">
                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="email" value="<?= e($row['email']) ?>">
                        <input type="hidden" name="name" value="<?= e($row['name']) ?>">
                        <input type="hidden" name="vehicle" value="<?= e($row['vehicle_name']) ?>">
                        <input type="hidden" name="date" value="<?= $date ?>">
                        <input type="hidden" name="time" value="<?= $time ?>">
                        <select name="status">
                            <option value="Pending"   <?= $row['status']=='Pending'   ? 'selected' : '' ?>>Pending</option>
                            <option value="Confirmed" <?= $row['status']=='Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="Completed" <?= $row['status']=='Completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="Cancelled" <?= $row['status']=='Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-update">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section style="margin-top:30px; text-align:center;">
        <h3>🚗 Booking Summary</h3>
        <div style="max-width:400px; margin:20px auto;">
            <canvas id="bookingChart"></canvas>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let statuses = <?= json_encode($statuses) ?>;
let counts = <?= json_encode($counts) ?>;

new Chart(document.getElementById('bookingChart'), {
    type: 'doughnut',
    data: {
        labels: statuses,
        datasets: [{
            data: counts,
            backgroundColor: ["#f1c40f","#2ecc71","#3498db","#e74c3c"],
            borderWidth: 2,
            borderColor: "#fff",
            hoverOffset: 20
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.parsed} bookings`;
                    }
                }
            }
        },
        animation: { animateRotate:true, animateScale:true, duration:1200 }
    }
});
</script>
</body>
</html>
