<?php
include '../db.php';

// Add part logic
if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $description = $_POST['description'];
  $image = '';

  // Image upload
  if (!empty($_FILES['image']['name'])) {
    $target_dir = "../assets/uploads/";
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true); // Create folder if missing
    }
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  }

  // SQL Insert
  $sql = "INSERT INTO vehicle_parts (part_name, category_id, price, stock, image, description, created_at)
          VALUES ('$name', NULL, '$price', '$stock', '$image', '$description', NOW())";
  mysqli_query($conn, $sql);
}

// Search logic
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
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, textarea { margin: 5px; padding: 8px; width: 300px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    .btn { padding: 6px 12px; background: blue; color: white; border: none; cursor: pointer; }
    .actions a { margin-right: 10px; }
  </style>
</head>
<body>

<h2>Add a New Part</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Part Name" required><br>
  <input type="text" name="category" placeholder="Category"><br>
  <input type="number" name="price" placeholder="Price" required><br>
  <input type="number" name="stock" placeholder="Stock"><br>
  <input type="file" name="image"><br>
  <textarea name="description" placeholder="Description"></textarea><br>
  <button type="submit" name="add" class="btn">Add Part</button>
</form>

<h3>List of Parts</h3>

<form method="get">
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
      <td>{$row['part_name']}</td>
      <td>{$row['description']}</td>
      <td>{$row['price']}</td>
      <td>{$row['stock']}</td>
      <td>";
    if ($row['image']) {
      echo "<img src='../assets/uploads/{$row['image']}' width='80'>";
    } else {
      echo "No image";
    }
    echo "</td>
      <td class='actions'>
        <a href='edit_part.php?id={$row['id']}'>Edit</a>
        <a href='delete_part.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this part?')\">Delete</a>
      </td>
    </tr>";
  }
  ?>
</table>

</body>
</html>