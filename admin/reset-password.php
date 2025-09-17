<?php
// reset-password.php
require_once __DIR__.'/../db.php';
$email = $_GET['email'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password=?, otp=NULL, otp_expiry=NULL WHERE email=?");
    $stmt->bind_param("ss", $password_hash, $email);
    $stmt->execute();
    echo "<p>Password reset successfully! <a href='login.php'>Login here</a></p>";
}
?>
<form method="POST">
    <h2>Reset Password</h2>
    <input type="password" name="password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
</form>
