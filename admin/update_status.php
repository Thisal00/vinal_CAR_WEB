<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

if ($_SESSION['role'] !== 'admin') {
  echo 'Access denied.';
  exit;
}

$id     = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

if ($id && in_array($action, ['approve', 'reject'])) {
  $status = ($action === 'approve') ? 'Approved' : 'Rejected';
  $mysqli->query("UPDATE part_messages SET status='$status' WHERE id='$id'");
}

header('Location: messages.php');
exit;