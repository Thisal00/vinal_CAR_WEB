<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

// 🔐 Only allow admin access
if ($_SESSION['role'] !== 'admin') {
  echo '<div style="padding:20px;color:red;">Access denied. Admins only.</div>';
  exit;
}

// ✅ Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo '<div style="padding:20px;color:red;">Invalid message ID.</div>';
  exit;
}

$id = (int)$_GET['id'];

// 🗑️ Delete message from database
$stmt = $mysqli->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  header("Location: messages.php?deleted=1");
  exit;
} else {
  echo '<div style="padding:20px;color:red;">Message not found or already deleted.</div>';
}
?>