<?php
require_once __DIR__.'/../db.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = mysqli_query($conn, "SELECT * FROM vehicle_parts WHERE id = $id");
$part = mysqli_fetch_assoc($result);

if (!$part) {
  echo "Part not found.";
  exit;
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT id, category_name FROM categories");

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $category_id = (int)($_POST['category'] ?? 0);
  $price = (float)($_POST['price'] ?? 0);
  $stock = (int)($_POST['stock'] ?? 0);
  $description = trim($_POST['description'] ?? '');
  $image = $part['image'] ?? '';

  if (!empty($_FILES['image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
      $image = uniqid('part_', true).'.'.$ext;
      move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../uploads/'.$image);
    } else {
      $msg = 'Invalid image type.';
    }
  }

  if (!$msg && $name && $category_id) {
    $sql = "UPDATE vehicle_parts SET 
              part_name = ?, category_id = ?, price = ?, stock = ?, image = ?, description = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sidissi', $name, $category_id, $price, $stock, $image, $description, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: parts.php");
    exit;
  } else if (!$msg) {
    $msg = 'Required: Part name and category.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Part - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <header style="display:flex;justify-content:space-between;align-items:center">
      <h2>Edit Vehicle Part</h2>
      <div><a class="btn" href="parts.php">Back</a></div>
    </header>

    <?php if ($msg) echo '<div class="alert">'.htmlspecialchars($msg).'</div>'; ?>

    <form method="POST" enctype="multipart/form-data" class="card form">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:10px">
        <input name="name" placeholder="Part Name" value="<?= htmlspecialchars($part['part_name']) ?>" required>
        <select name="category" required>
          <?php while ($cat = mysqli_fetch_assoc($categories)) {
            $selected = ($cat['id'] == $part['category_id']) ? 'selected' : '';
            $cat_name = $cat['category_name'] ?? 'Unnamed Category';
            echo "<option value='{$cat['id']}' $selected>".htmlspecialchars($cat_name)."</option>";
          } ?>
        </select>
        <input type="number" step="0.01" name="price" placeholder="Price (LKR)" value="<?= htmlspecialchars($part['price']) ?>">
        <input type="number" name="stock" placeholder="Stock Quantity" value="<?= htmlspecialchars($part['stock']) ?>">
      </div>

      <textarea name="description" placeholder="Description"><?= htmlspecialchars($part['description']) ?></textarea>

      <div>
        <?php if (!empty($part['image'])) echo '<img style="max-width:180px" src="../uploads/'.htmlspecialchars($part['image']).'">'; ?>
      </div>

      <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
      <img id="preview" style="max-width:180px;margin-top:10px">

      <button type="submit" name="update" class="btn">Save Changes</button>
    </form>
  </div>

  <script>
    function previewImage(event) {
      const reader = new FileReader();
      reader.onload = function(){
        document.getElementById('preview').src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</body>
</html>