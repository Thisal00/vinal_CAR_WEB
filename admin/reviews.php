<?php require_once __DIR__.'/../db.php'; require_login(); ?>
<?php
  if (isset($_GET['approve'])) {
    $id=(int)$_GET['approve']; $stmt=$mysqli->prepare("UPDATE reviews SET status='approved' WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close(); header('Location: reviews.php'); exit;
  }
  if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete']; $stmt=$mysqli->prepare("DELETE FROM reviews WHERE id=?");
    $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close(); header('Location: reviews.php'); exit;
  }
?>
<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Reviews - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
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
        <a href="messages.php" >Messages</a>
        <a href="reviews.php" class="active">Reviews</a>
        <a href="bookings.php">Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>
    <h3>Pending</h3>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Rating</th><th>Comment</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
        $res = $mysqli->query("SELECT * FROM reviews WHERE status='pending' ORDER BY id DESC");
        while ($r = $res->fetch_assoc()) {
          echo '<tr>';
          echo '<td>'.(int)$r['id'].'</td>';
          echo '<td>'.e($r['name']).'</td>';
          echo '<td>'.(int)$r['rating'].'/5</td>';
          echo '<td>'.e($r['comment']).'</td>';
          echo '<td class="actions"><a href="reviews.php?approve='.(int)$r['id'].'">Approve</a> <a href="reviews.php?delete='.(int)$r['id'].'" onclick="return confirm(\'Delete?\')">Delete</a></td>';
          echo '</tr>';
        }
      ?>
      </tbody>
    </table>

    <h3>Approved</h3>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Rating</th><th>Comment</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
        $res = $mysqli->query("SELECT * FROM reviews WHERE status='approved' ORDER BY id DESC");
        while ($r = $res->fetch_assoc()) {
          echo '<tr>';
          echo '<td>'.(int)$r['id'].'</td>';
          echo '<td>'.e($r['name']).'</td>';
          echo '<td>'.(int)$r['rating'].'/5</td>';
          echo '<td>'.e($r['comment']).'</td>';
          echo '<td>'.e($r['created_at']).'</td>';
          echo '<td class="actions"><a href="reviews.php?delete='.(int)$r['id'].'" onclick="return confirm(\'Delete?\')">Delete</a></td>';
          echo '</tr>';
        }
      ?>
      </tbody>
    </table>
  </div>
</body></html>
