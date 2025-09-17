<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// First, fetch image name to delete from uploads folder
$result = mysqli_query($conn, "SELECT image FROM vehicle_parts WHERE id = $id");
$part = mysqli_fetch_assoc($result);

if ($part) {
  // Delete image file if exists
  $image_path = '../uploads/' . $part['image'];
  if (file_exists($image_path)) {
    unlink($image_path);
  }

  // Delete part from database
  mysqli_query($conn, "DELETE FROM vehicle_parts WHERE id = $id");
}

header("Location: parts.php");
exit;
?>