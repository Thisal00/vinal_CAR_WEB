<?php
include 'db.php'; // Correct path

// Validate part ID
if (!isset($_GET['id'])) {
  die("Invalid part ID.");
}
$part_id = intval($_GET['id']);

// Simulate wishlist insert (replace with real logic)
$user_id = 1; // Replace with session user ID if available

$sql = "INSERT INTO wishlist (user_id, part_id, added_at) VALUES ('$user_id', '$part_id', NOW())";
if ($conn->query($sql)) {
  echo "<p style='color:green;'>Part added to wishlist!</p>";
} else {
  echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
}

?>
