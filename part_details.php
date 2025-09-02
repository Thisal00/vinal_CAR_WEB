<?php
include '../db.php';
$id = intval($_GET['id']);
$part = $conn->query("SELECT * FROM parts WHERE id=$id")->fetch_assoc();
echo "<h2>{$part['part_name']}</h2>";
echo "<p>Price: {$part['price']}</p>";
echo "<form method='POST' action='add_to_wishlist.php'>
<input type='hidden' name='part_id' value='{$part['id']}'>
<button>Add to Wishlist</button></form>";
?>

<?php
// Connect to database
include 'db.php';

// Validate and get part ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h3>Invalid part ID.</h3>";
    exit;
}

$id = intval($_GET['id']);

// Fetch part data
$sql = "SELECT * FROM parts WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<h3>Part not found.</h3>";
    exit;
}

$part = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $part['part_name']; ?> - Part Details</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        .part-box { background: #fff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        img { max-width: 100%; height: auto; border-radius: 4px; }
        h2 { color: #333; }
        p { font-size: 16px; color: #555; }
        .back-link { margin-top: 20px; display: inline-block; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="part-box">
    <h2><?php echo htmlspecialchars($part['part_name']); ?></h2>
    <img src="uploads/<?php echo htmlspecialchars($part['image']); ?>" alt="Part Image">
    <p><strong>Price:</strong> Rs. <?php echo htmlspecialchars($part['price']); ?></p>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($part['description'])); ?></p>
    <?php if (!empty($part['category'])): ?>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($part['category']); ?></p>
    <?php endif; ?>
    <a class="back-link" href="parts.php">← Back to Parts</a>
</div>
<form method="POST" action="add_to_wishlist.php">
  <input type="hidden" name="part_id" value="<?php echo $part['id']; ?>">
  <input type="submit" value="❤️ Add to Wishlist">
</form>

</body>
</html>