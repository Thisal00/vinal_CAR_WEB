<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($conn, "SELECT * FROM vehicle_parts WHERE id = $id");
$part = mysqli_fetch_assoc($result);

if (!$part) {
  echo "Part not found.";
  exit;
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT id, name FROM categories");

// Update logic
if (isset($_POST['update'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $category_id = intval($_POST['category']);
  $price = floatval($_POST['price']);
  $stock = intval($_POST['stock']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $image = $part['image'];

  if (!empty($_FILES['image']['name'])) {
    $target_dir = "../uploads/";
    $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $unique_name;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image = $unique_name;
    }
  }

  $sql = "UPDATE vehicle_parts SET 
            part_name = '$name',
            category_id = '$category_id',
            price = '$price',
            stock = '$stock',
            image = '$image',
            description = '$description'
          WHERE id = $id";
  mysqli_query($conn, $sql);
  header("Location: parts.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Part</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, textarea, select { margin: 5px; padding: 8px; width: 300px; }
    .btn { padding: 6px 12px; background: green; color: white; border: none; cursor: pointer; }
    img { margin-top: 10px; max-width: 100px; }
  </style>
</head>
<body>

<h2>Edit Part</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" value="<?= htmlspecialchars($part['part_name']) ?>" required><br>

  <select name="category" required>
    <?php while ($cat = mysqli_fetch_assoc($categories)) {
      $selected = ($cat['id'] == $part['category_id']) ? 'selected' : '';
      echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
    } ?>
  </select><br>

  <input type="number" name="price" value="<?= $part['price'] ?>" required><br>
  <input type="number" name="stock" value="<?= $part['stock'] ?>"><br>
  <input type="file" name="image"><br>
  <?php if ($part['image']) {
    echo "<img src='../uploads/" . htmlspecialchars($part['image']) . "'>";
  } ?>
  <textarea name="description"><?= htmlspecialchars($part['description']) ?></textarea><br>
  <button type="submit" name="update" class="btn">Update Part</button>
</form>

</body>
</html>