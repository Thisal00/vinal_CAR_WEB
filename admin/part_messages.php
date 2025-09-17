<?php
// Start session if not active
if (session_status() === PHP_SESSION_NONE) session_start();

// DB connection
$mysqli = new mysqli("localhost", "root", "", "vinal_auto");
if ($mysqli->connect_error) die("Database connection failed: " . $mysqli->connect_error);

// Escape helper
if (!function_exists('e')) {
    function e($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title> Part Requests</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
/* Custom button overrides for this page */
.btn-reply { background: #d4af37; color: #0b1e3f; margin-right:5px; }
.btn-view { background: #28a745; color:#fff; margin-right:5px; }
.btn-delete { background: #dc3545; color:#fff; margin-right:5px; }
table { width:100%; border-collapse: collapse; }
th, td { padding:10px; border-bottom:1px solid #2c3e50; font-size:14px; text-align:left; }
th { background:#162b4d; color:#ffd700; }
td img { border-radius:6px; max-width:80px; }
</style>
</head>
<body>
<div class="container">
    <!-- HEADER -->
    <header class="flex-between">
      <h2>Part Requests</h2>
        <div>
            Welcome, <?= e($_SESSION['username'] ?? 'Admin') ?> |
            <a class="btn" href="logout.php">Logout</a>
        </div>
    </header>

    <!-- NAVIGATION -->
   <nav class="nav-links">
        <a href="vehicles.php">Vehicles</a>
        <a href="parts.php">Parts</a>
        <a href="part_messages.php" class="active">Orders</a>
        <a href="users.php">Users</a>
        <a href="messages.php">Messages</a>
        <a href="reviews.php">Reviews</a>
        <a href="bookings.php">Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>
    <!-- CONTENT -->
    <section style="margin-top:20px;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Part Name</th>
                    <th>Part ID</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Requested At</th>
                    <th>Status</th>
                    <th>Reply</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT m.id, m.customer_name, m.phone, m.message, m.status, m.reply, m.created_at, m.part_id, p.part_name AS part_name
                          FROM part_messages m
                          LEFT JOIN vehicle_parts p ON m.part_id = p.id
                          ORDER BY m.created_at DESC";
                $res = $mysqli->query($query);

                if (!$res) {
                    echo '<tr><td colspan="10" style="color:red;">SQL Error: '.$mysqli->error.'</td></tr>';
                } elseif ($res->num_rows === 0) {
                    echo '<tr><td colspan="10"><em>No part messages found.</em></td></tr>';
                } else {
                    while ($row = $res->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.(int)$row['id'].'</td>';
                        echo '<td>'.e($row['part_name'] ?? 'Unknown').'</td>';
                        echo '<td>'.(int)$row['part_id'].'</td>';
                        echo '<td>'.e($row['customer_name']).'</td>';
                        echo '<td>'.e($row['phone']).'</td>';
                        echo '<td>'.substr(e($row['message']),0,40).'...</td>';
                        echo '<td>'.e($row['created_at']).'</td>';
                        echo '<td>'.e($row['status'] ?? 'Pending').'</td>';
                        echo '<td>'.($row['reply'] ? substr(e($row['reply']),0,40).'...' : '<em>No reply</em>').'</td>';
                        echo '<td>
                            <a href="reply_part.php?id='.$row['id'].'" class="btn-reply btn">Reply</a>';
                        if ($row['status']==='Pending' || $row['status']==='unread') {
                            echo '<a href="update_status.php?id='.$row['id'].'&action=approve" class="btn-view btn">✅ Approve</a>';
                            echo '<a href="update_status.php?id='.$row['id'].'&action=reject" class="btn-delete btn">❌ Reject</a>';
                        }
                        echo '<a href="delete_part.php?id='.$row['id'].'" class="btn-delete btn" onclick="return confirm(\'Delete this request?\')">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>

