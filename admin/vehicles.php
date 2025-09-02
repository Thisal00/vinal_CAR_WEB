<?php require_once __DIR__.'/../db.php'; require_login(); ?>
<?php
  // Delete handler
  if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM vehicles WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute(); $stmt->close();
    header('Location: vehicles.php'); exit;
  }
?>
<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Vehicles - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <header style="display:flex;justify-content:space-between;align-items:center">
      <h2>Manage Vehicles</h2>
      <div><a class="btn" href="dashboard.php">Dashboard</a> <a class="btn" href="logout.php">Logout</a></div>
    </header>

    <p><a class="btn" href="add_vehicle.php">+ Add Vehicle</a></p>

    <table>
      <thead><tr><th>ID</th><th>Photo</th><th>Title</th><th>Price</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
        $res = $mysqli->query("SELECT id, make, model, year, price, image FROM vehicles ORDER BY id DESC");
        while ($v = $res->fetch_assoc()) {
          $img = $v['image'] ? '../assets/images/uploads/'.e($v['image']) : '../assets/images/no-car.png';
          echo '<tr>';
          echo '<td>'.(int)$v['id'].'</td>';
          echo '<td><img style="width:80px;height:auto" src="'.e($img).'"></td>';
          echo '<td>'.e($v['year']).' '.e($v['make']).' '.e($v['model']).'</td>';
          echo '<td>LKR '.number_format((float)$v['price'],2).'</td>';
          echo '<td class="actions">';
          echo '  <a href="add_vehicle.php?id='.(int)$v['id'].'">Edit</a>';
          echo '  <a href="vehicles.php?delete='.(int)$v['id'].'" onclick="return confirm(\'Delete this vehicle?\')">Delete</a>';
          echo '</td>';
          echo '</tr>';
        }
      ?>
      </tbody>
    </table>
  </div>
</body></html>
