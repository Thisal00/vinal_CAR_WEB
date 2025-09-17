
<?php
require_once '../db.php';
$token = $_POST['token'];
$newPass = $_POST['new_password'];
$hash = password_hash($newPass, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE users SET password_hash=?, reset_token=NULL, token_expiry=NULL WHERE reset_token=?");
$stmt->bind_param('ss', $hash, $token);
$stmt->execute();

echo "Password has been reset. <a href='login.php'>Login now</a>";
?>