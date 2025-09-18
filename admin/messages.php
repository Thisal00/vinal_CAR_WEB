<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

//  Admin access only
if ($_SESSION['role'] !== 'admin') {
  echo '<div style="padding:20px;color:red;">Access denied. Admins only.</div>';
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Messages - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
     .btn-edit {
      background-color: #007bff;
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
    }
    .btn-edit:hover, .btn-delete:hover {
      opacity: 0.85;
    }
    .actions {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
    }
    table img {
      border-radius: 4px;
    }
    .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; margin-right: 5px; }
    .btn-view { background: #ffd700; color: #0b1e3f; }
    .btn-reply { background: #00c853; color: #fff; }
    .btn-delete { background: #d50000; color: #fff; }
    .btn-dashboard { background: #ffd700; color: #0b1e3f; padding: 10px 20px; display: inline-block; margin-bottom: 20px; border-radius: 6px; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <header class="flex-between">
      <h2>Manage Vehicles</h2>
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
        <a href="messages.php" class="active">Messages</a>
        <a href="reviews.php">Reviews</a>
        <a href="bookings.php">Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>

    <!-- Contact Messages -->
    <h2> Contact Messages</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Sent At</th>
          <th>Status</th>
          <th>Reply</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $res = $mysqli->query("SELECT id, name, email, message, status, reply, created_at FROM messages ORDER BY created_at DESC");
        while ($row = $res->fetch_assoc()) {
          echo '<tr>';
          echo '<td>'.(int)$row['id'].'</td>';
          echo '<td>'.htmlspecialchars($row['name']).'</td>';
          echo '<td>'.htmlspecialchars($row['email']).'</td>';
          echo '<td title="'.htmlspecialchars($row['message']).'">'.substr(htmlspecialchars($row['message']), 0, 40).'...</td>';
          echo '<td>'.htmlspecialchars($row['created_at']).'</td>';
          echo '<td>'.htmlspecialchars($row['status'] ?? 'Pending').'</td>';
          echo '<td>'.($row['reply'] ? substr(htmlspecialchars($row['reply']), 0, 40).'...' : '<em>No reply</em>').'</td>';
          echo '<td>
                  <a href="view_message.php?id='.$row['id'].'" class="btn btn-view">View</a>
                  <a href="reply_message.php?id='.$row['id'].'" class="btn btn-reply">Reply</a>
                  <a href="delete_message.php?id='.$row['id'].'" class="btn btn-delete" onclick="return confirm(\'Are you sure?\')">Delete</a>
                </td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>

    <!--  Part Requests -->
    <h2> Part Requests</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Part Name</th>
          <th>Part ID</th>
          <th>Order Code</th>
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
        $res = $mysqli->query("SELECT m.id, m.customer_name, m.phone, m.message, m.status, m.reply, m.created_at, m.part_id, m.order_code, p.name AS part_name  
                               FROM part_messages m  
                               LEFT JOIN vehicle_parts p ON m.part_id = p.id  
                               ORDER BY m.created_at DESC");
        while ($row = $res->fetch_assoc()) {
          echo '<tr>';
          echo '<td>'.(int)$row['id'].'</td>';
          echo '<td>'.htmlspecialchars($row['part_name']).'</td>';
          echo '<td>'.(int)$row['part_id'].'</td>';
          echo '<td>'.htmlspecialchars($row['order_code']).'</td>';
          echo '<td>'.htmlspecialchars($row['customer_name']).'</td>';
          echo '<td>'.htmlspecialchars($row['phone']).'</td>';
          echo '<td title="'.htmlspecialchars($row['message']).'">'.substr(htmlspecialchars($row['message']), 0, 40).'...</td>';
          echo '<td>'.htmlspecialchars($row['created_at']).'</td>';
          echo '<td>'.htmlspecialchars($row['status'] ?? 'Pending').'</td>';
          echo '<td>'.($row['reply'] ? substr(htmlspecialchars($row['reply']), 0, 40).'...' : '<em>No reply</em>').'</td>';
          echo '<td>
                  <a href="reply_part.php?id='.$row['id'].'" class="btn btn-reply">Reply</a>';
          if ($row['status'] === 'Pending') {
            echo '<a href="update_status.php?id='.$row['id'].'&action=approve" class="btn btn-view">✅ Approve</a>';
            echo '<a href="update_status.php?id='.$row['id'].'&action=reject" class="btn btn-delete">❌ Reject</a>';
          }
          echo '<a href="delete_part.php?id='.$row['id'].'" class="btn btn-delete" onclick="return confirm(\'Delete this request?\')">Delete</a>';
          echo '</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>
