<?php require_once __DIR__.'/../db.php'; require_login(); ?>

<?php
  // Delete handler
  if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM vehicles WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: vehicles.php');
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Vehicles - Vinal Auto</title>
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
    .btn-print {
      background-color: #28a745; /* Green color */
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
    }
    .btn-edit:hover, .btn-delete:hover, .btn-print:hover {
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
      <a href="vehicles.php"  class="active">Vehicles</a>
      <a href="parts.php">Parts</a>
      <a href="part_messages.php">Orders</a>
      <a href="users.php">Users</a>
      <a href="messages.php">Messages</a>
      <a href="reviews.php">Reviews</a>
      <a href="bookings.php">Test Drives</a>
      <a href="compare_add.php">Compare</a>
    </nav>

    <p><a class="btn" href="add_vehicle.php">+ Add Vehicle</a></p>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Photo</th>
          <th>Title</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $res = $mysqli->query("SELECT id, make, model, year, price, image FROM vehicles ORDER BY id DESC");
          while ($v = $res->fetch_assoc()) {
            $img = $v['image'] ? '../assets/images/uploads/'.e($v['image']) : '../assets/images/no-car.png';
            echo '<tr>';
            echo '<td>'.(int)$v['id'].'</td>';
            echo '<td><img style="width:80px;height:auto" src="'.e($img).'"></td>';
            echo '<td>'.e($v['year']).' '.e($v['make']).' '.e($v['model']).'</td>';
            echo '<td>LKR '.number_format((float)$v['price'], 2).'</td>';
            echo '<td class="actions">';
            echo '  <a href="edit_vehicle.php?id='.(int)$v['id'].'" class="btn-edit">Edit</a>';
            echo '  <a href="vehicles.php?delete='.(int)$v['id'].'" class="btn-delete" onclick="return confirm(\'Delete this vehicle?\')">Delete</a>';
            echo '  <a class="btn-print" href="createpdf.php?id='.(int)$v['id'].'" target="_blank">Print PDF</a>';
            echo '</td>';
            echo '</tr>';
          }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
