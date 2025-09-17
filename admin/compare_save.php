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
    header("Location: compare.php");
    exit;
}

// --- Delete vehicle ---
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM vehicle_list WHERE id=$del_id");
    $_SESSION['msg'] = "🗑 Vehicle deleted!";
    header("Location: compare.php");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0b1e3f;
      color: white;
      font-family: "Segoe UI", sans-serif;
      padding: 20px;
    }
    .card {
      background-color: #1f3b6e;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 5px 12px rgba(0,0,0,0.4);
    }
    input, button, select {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 6px;
      border: none;
    }
    button {
      font-weight: bold;
      cursor: pointer;
    }
    h2, h3 {
      text-align: center;
      color: #00d4ff;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
    }
    th {
      background-color: #007bff;
      color: white;
      text-align: center;
    }
    td {
      background-color: #1f3b6e;
      text-align: center;
      vertical-align: middle;
    }
    .btn-edit {
      background-color: #ffc107;
      color: black;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
    }
    .filter-btn {
      margin-bottom: 15px;
    }
    .actions {
      display: flex;
      gap: 6px;
      justify-content: center;
    }
  </style>
</head>
<body>

<div class="container">
  <header class="d-flex justify-content-between align-items-center mb-4">
    <h2>🚗 Vehicle Management</h2>
    <div>
      Welcome, <?= e($_SESSION['username'] ?? '') ?> |
      <a class="btn btn-light btn-sm" href="dashboard.php">Dashboard</a> |
      <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
    </div>
  </header>

  <!-- Flash Messages -->
  <?php if (!empty($_SESSION['msg'])): ?>
    <div class="alert alert-info text-center">
      <?= e($_SESSION['msg']); unset($_SESSION['msg']); ?>
    </div>
  <?php endif; ?>

  <!-- Add / Edit Form -->
  <div class="card">
    <h3 id="form-title">➕ Add Vehicle</h3>
    <form method="POST">
      <input type="hidden" name="vehicle_id" id="vehicle_id">
      <input type="text" name="model_name" id="model_name" placeholder="Model Name" required>
      <input type="text" name="fuel_efficiency" id="fuel_efficiency" placeholder="Fuel Efficiency (km/l)" required>
      <input type="number" name="price" id="price" placeholder="Price (Rs)" required>
      <input type="text" name="resale_value" id="resale_value" placeholder="Resale Value" required>
      <button type="submit" class="btn btn-success w-100" name="save_vehicle">💾 Save Vehicle</button>
    </form>
  </div>

  <!-- Search + Sort -->
  <form method="get" class="d-flex justify-content-center mb-3">
    <input type="text" name="q" placeholder="Search model..." value="<?= e($q) ?>" class="form-control w-25 me-2">
    <button type="submit" class="btn btn-info me-2">🔍 Search</button>
    <a href="?sort=new" class="btn btn-info me-2">⬆ Newest</a>
    <a href="?sort=old" class="btn btn-secondary">⬇ Oldest</a>
  </form>

  <!-- Vehicle Table -->
  <div class="card">
    <h3>📋 Vehicle List</h3>
    <div class="table-responsive">
      <table class="table table-bordered text-white">
        <thead>
          <tr>
            <th>ID</th>
            <th>Model</th>
            <th>Fuel Efficiency</th>
            <th>Price</th>
            <th>Resale Value</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= e($row['model_name']); ?></td>
            <td><?= $row['fuel_efficiency']; ?> km/l</td>
            <td>Rs. <?= number_format($row['price']); ?></td>
            <td>Rs. <?= number_format($row['resale_value']); ?></td>
            <td class="actions">
              <button class="btn btn-sm btn-edit"
                onclick="editVehicle('<?= $row['id']; ?>','<?= e($row['model_name']); ?>','<?= $row['fuel_efficiency']; ?>','<?= $row['price']; ?>','<?= $row['resale_value']; ?>')">
                ✏️ Edit
              </button>
              <a href="?delete=<?= $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Delete this vehicle?')">❌ Delete</a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Fill form for editing
  function editVehicle(id, model, fuel, price, resale) {
    document.getElementById('vehicle_id').value = id;
    document.getElementById('model_name').value = model;
    document.getElementById('fuel_efficiency').value = fuel;
    document.getElementById('price').value = price;
    document.getElementById('resale_value').value = resale;
    document.getElementById('form-title').innerText = "✏️ Edit Vehicle";
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

</body>
</html>
   