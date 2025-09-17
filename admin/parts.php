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

// --- Add part logic ---
if (isset($_POST['add'])) {
    $name        = $_POST['name'];
    $category    = $_POST['category'];
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $description = $_POST['description'];
    $image       = '';

    // --- Image upload ---
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // --- SQL Insert ---
    $sql = "INSERT INTO vehicle_parts (part_name, category_id, price, stock, image, description, created_at)
            VALUES ('$name', NULL, '$price', '$stock', '$image', '$description', NOW())";
    mysqli_query($conn, $sql);
}

// --- Search logic ---
$where = '';
$q = $_GET['q'] ?? '';
if (!empty($q)) {
    $safe_q = mysqli_real_escape_string($conn, $q);
    $where = "WHERE part_name LIKE '%$safe_q%'";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parts Management</title>
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
  </style>
</head>
<body>
  <div class="container">
    <header class="flex-between">
      <h2>Parts Management</h2>
      <div>
        Welcome, <?= e($_SESSION['username'] ?? '') ?> |
        <a class="btn" href="dashboard.php">Back to Dashboard</a> |
        <a class="btn" href="logout.php">Logout</a>
      </div>
    </header>

    <nav class="nav-links">
        <a href="vehicles.php">Vehicles</a>
        <a href="parts.php" class="active">Parts</a>
        <a href="part_messages.php">Orders</a>
        <a href="users.php">Users</a>
        <a href="messages.php">Messages</a>
        <a href="reviews.php">Reviews</a>
        <a href="bookings.php">Test Drives</a>
        <a href="compare_add.php">Compare</a>
    </nav>

    <section style="margin-top:20px">
      <h3>Add a New Part</h3>
      <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Part Name" required><br>
        <input type="text" name="category" placeholder="Category"><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <input type="number" name="stock" placeholder="Stock"><br>
        <input type="file" name="image"><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <button type="submit" name="add" class="btn">Add Part</button>
      </form>
    </section>

    <section style="margin-top:30px">
      <h3>List of Parts</h3>

      <form method="get" style="margin-bottom:15px;">
        <input type="text" name="q" placeholder="Search part name..." value="<?= htmlspecialchars($q) ?>">
        <button type="submit" class="btn">Search</button>
      </form>

      <table>
        <tr>
          <th>ID</th>
          <th>Part Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM vehicle_parts $where ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>".e($row['part_name'])."</td>
              <td>".e($row['description'])."</td>
              <td>".e($row['price'])."</td>
              <td>".e($row['stock'])."</td>
              <td>";
            if ($row['image']) {
                echo "<img src='../assets/uploads/".e($row['image'])."' width='80'>";
            } else {
                echo "No image";
            }
            echo "</td>
              <td class='actions'>
                <a class='btn-edit' href='edit_part.php?id={$row['id']}'>Edit</a>
                <a class='btn-delete' href='delete_part.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this part?')\">Delete</a>
              </td>
            </tr>";
        }
        ?>
      </table>
    </section>
  </div>
</body>
</html>