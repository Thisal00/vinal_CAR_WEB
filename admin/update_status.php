<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

//  Only allow admin access
if ($_SESSION['role'] !== 'admin') {
  echo '<div style="padding:20px;color:red;">Access denied. Admins only.</div>';
  exit;
}

//  Get message ID and action
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? '';

//  Validate input
if ($id <= 0 || !in_array($action, ['approve', 'reject'])) {
  echo '<div style="padding:20px;color:red;">Invalid request parameters.</div>';
  exit;
}

//  Determine new status
$status = $action === 'approve' ? 'approved' : 'rejected';

//  Update status in database
$stmt = $mysqli->prepare("UPDATE part_messages SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
  //  Redirect back with success flag
  header("Location: messages.php?status_updated=1");
  exit;
} else {
  echo '<div style="padding:20px;color:red;">Database error: '.$mysqli->error.'</div>';
}

?>
