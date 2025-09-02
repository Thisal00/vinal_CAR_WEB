<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

// 🔐 Only allow admin access
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
    body { font-family: 'Poppins', sans-serif; background: #0b1e3f; color: #fff; }
    .container { max-width: 1000px; margin: 40px auto; padding: 20px; background: #11182e; border-radius: 10px; }
    h2 { color: #ffd700; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    th, td { padding: 12px; border-bottom: 1px solid #444; text-align: left; }
    th { background-color: #0b1e3f; color: #ffd700; }
    td { background-color: #1a233a; }
    .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; margin-right: 5px; }
    .btn-view { background: #ffd700; color: #0b1e3f; }
    .btn-reply { background: #00c853; color: #fff; }
    .btn-delete { background: #d50000; color: #fff; }
    .btn-dashboard { background: #ffd700; color: #0b1e3f; padding: 10px 20px; display: inline-block; margin-bottom: 20px; border-radius: 6px; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <a href="dashboard.php" class="btn-dashboard">← Go to Dashboard</a>

    <!-- 📬 Contact Messages -->
    <h2>📬 Contact Messages</h2>
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
          echo '<td>'.substr(htmlspecialchars($row['message']), 0, 40).'...</td>';
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

    <!-- 🛠️ Part Requests -->
    <h2>🛠️ Part Requests</h2>
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
          echo '<td>'.substr(htmlspecialchars($row['message']), 0, 40).'...</td>';
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