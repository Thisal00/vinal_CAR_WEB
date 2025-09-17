<?php
require_once __DIR__.'/../db.php';

$email = $_POST['email'] ?? '';
if (!$email) {
  echo "Email required.";
  exit;
}

$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

$stmt = $mysqli->prepare("UPDATE users SET reset_token=?, token_expiry=? WHERE email=?");
$stmt->bind_param('sss', $token, $expiry, $email);
$stmt->execute();

$link = "http://localhost/vinal_auto/admin/reset.php?token=$token";
$subject = "🔐 Vinal Auto Password Reset";
$message = "Hello,\n\nClick the link below to reset your password:\n$link\n\nThis link will expire in 15 minutes.";
$headers = "From: Vinal Auto <no-reply@vinalauto.local>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($email, $subject, $message, $headers);

echo "Reset link sent to your email.";
?>