<?php
require_once __DIR__.'/../db.php';
require_login();

if ($_SESSION['role'] !== 'admin') {
  exit('Access denied');
}

$to = $_POST['to_email'] ?? '';
$reply = $_POST['reply'] ?? '';

if ($to && $reply) {
  $subject = "Reply from Vinal Auto";
  $headers = "From: info@vinalauto.lk\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8";

  mail($to, $subject, $reply, $headers);
  echo "<div style='padding:20px;color:#ffd700;'>✅ Reply sent to $to</div>";
  echo "<a href='messages.php' style='color:#fff;'>← Back to Messages</a>";
} else {
  echo "<div style='padding:20px;color:red;'>⚠️ Missing email or reply content.</div>";
}