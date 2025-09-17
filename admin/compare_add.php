<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';

// --- Escape helper ---
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

// --- Add / Update vehicle ---
if (isset($_POST['save_vehicle'])) {
    $id     = $_POST['vehicle_id'] ?? '';
    $model  = $conn->real_escape_string($_POST['model_name']);
    $fuel   = floatval($_POST['fuel_efficiency']);
    $price  = intval($_POST['price']);
    $resale = floatval($_POST['resale_value']);

    if (!empty($id)) {
        // Update
        $sql = "UPDATE vehicle_list 
                SET model_name='$model', fuel_efficiency='$fuel', price='$price', resale_value='$resale' 
                WHERE id=$id";
        $conn->query($sql);
        $_SESSION['msg'] = "✅ Vehicle updated successfully!";
    } else {
        // Insert
        $sql = "INSERT INTO vehicle_list (model_name, fuel_efficiency, price, resale_value)
                VALUES ('$model','$fuel','$price','$resale')";
        $conn->query($sql);
        $_SESSION['msg'] = "✅ Vehicle added successfully!";
    }
}

// --- Delete vehicle via POST (for AJAX) ---
if (isset($_POST['delete_vehicle'])) {
    $del_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM vehicle_list WHERE id=$del_id");
    $_SESSION['msg'] = "🗑 Vehicle deleted!";
    echo json_encode(['status' => 'success', 'message' => $_SESSION['msg']]);
    exit;
}

// --- Search ---
$where = '';
$q = $_GET['q'] ?? '';
if (!empty($q)) {
    $safe_q = $conn->real_escape_string($q);
    $where = "WHERE model_name LIKE '%$safe_q%'";
}

// --- Sorting ---
$order = "DESC";
if (isset($_GET['sort']) && $_GET['sort'] === "old") {
    $order = "ASC";
}
$result = $conn->query("SELECT * FROM vehicle_list $where ORDER BY id $order");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vehicle Management</title>
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
    .flex-between {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .nav-links {
      display: flex;
      gap: 15px;
      margin: 15px 0;
    }
    .nav-links a {
      color: #ffffffff;
      text-decoration: none;
    }   
    .nav-links a:hover {
      text-decoration: underline;
    }
    .nav-links a.active {
      font-weight: bold;
      color: #fddc09c1;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="flex-between">
      <h2>Vehicle Management</h2>
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
        <a href="bookings.php">Test Drives</a>
        <a href="compare_add.php" class="active">Compare</a>
    </nav>

    <!-- Flash Messages -->
    <div id="flash-message" style="display: none; background-color: #d4edda; color: #d4d414ff; padding: 10px; border-radius: 4px; margin: 15px 0; text-align: center;"></div>
    <?php if (!empty($_SESSION['msg'])): ?>
      <div style="background-color: #d4edda; color: #cec81bff; padding: 10px; border-radius: 4px; margin: 15px 0; text-align: center;">
        <?= e($_SESSION['msg']); unset($_SESSION['msg']); ?>
      </div>
    <?php endif; ?>

    <section style="margin-top:20px">
      <h3 id="form-title">Add a New Vehicle</h3>
      <form method="POST">
        <input type="hidden" name="vehicle_id" id="vehicle_id">
        <input type="text" name="model_name" id="model_name" placeholder="Model Name" required><br>
        <input type="number" step="0.01" name="fuel_efficiency" id="fuel_efficiency" placeholder="Fuel Efficiency (km/l)" required><br>
        <input type="number" name="price" id="price" placeholder="Price (Rs)" required><br>
        <input type="number" step="0.01" name="resale_value" id="resale_value" placeholder="Resale Value (Rs)" required><br>
        <button type="submit" name="save_vehicle" class="btn">Save Vehicle</button>
      </form>
    </section>

    <section style="margin-top:30px">
      <h3>List of Vehicles</h3>

      <form method="get" style="margin-bottom:15px;">
        <input type="text" name="q" placeholder="Search model..." value="<?= e($q) ?>">
        <button type="submit" class="btn">Search</button>
        <a href="?sort=new" class="btn">Newest</a>
        <a href="?sort=old" class="btn">Oldest</a>
      </form>

      <table>
        <tr>
          <th>ID</th>
          <th>Model</th>
          <th>Fuel Efficiency</th>
          <th>Price</th>
          <th>Resale Value</th>
          <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= e($row['model_name']); ?></td>
            <td><?= e($row['fuel_efficiency']); ?> km/l</td>
            <td>Rs. <?= number_format($row['price']); ?></td>
            <td>Rs. <?= number_format($row['resale_value']); ?></td>
            <td class="actions">
              <a class="btn-edit" href="javascript:void(0)" onclick="editVehicle('<?= $row['id']; ?>','<?= e($row['model_name']); ?>','<?= $row['fuel_efficiency']; ?>','<?= $row['price']; ?>','<?= $row['resale_value']; ?>')">Edit</a>
              <a class="btn-delete" href="javascript:void(0)" onclick="deleteVehicle(<?= $row['id']; ?>)">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </section>
  </div>

  <script>
    // Fill form for editing
    function editVehicle(id, model, fuel, price, resale) {
      document.getElementById('vehicle_id').value = id;
      document.getElementById('model_name').value = model;
      document.getElementById('fuel_efficiency').value = fuel;
      document.getElementById('price').value = price;
      document.getElementById('resale_value').value = resale;
      document.getElementById('form-title').innerText = "Edit Vehicle";
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // AJAX for deleting vehicle
    function deleteVehicle(id) {
      if (!confirm('Delete this vehicle?')) return;
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'vehicles.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          const flash = document.getElementById('flash-message');
          flash.innerText = response.message;
          flash.style.display = 'block';
          setTimeout(() => location.reload(), 1500); // Refresh after 1.5s
        }
      };
      xhr.send('delete_vehicle=1&delete_id=' + id);
    }
  </script>
</body>
</html>