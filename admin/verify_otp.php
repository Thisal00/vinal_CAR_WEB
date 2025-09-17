<?php
session_start();
require_once "../db.php";

$msg = "";
$otp_expired = false;
$email = $_SESSION['reset_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $email) {
    $otp = trim($_POST['otp']);
    $stmt = $mysqli->prepare("SELECT reset_otp, otp_expires FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && $otp == $user['reset_otp'] && strtotime($user['otp_expires']) > time()) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit;
    } else {
        $msg = "❌ Invalid or expired OTP!";
        if ($user && strtotime($user['otp_expires']) <= time()) $otp_expired = true;
    }
} elseif (!$email) {
    $msg = "❌ Session expired. Try again.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify OTP - Vinal Auto</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
main.container { max-width:400px; margin:80px auto; padding:30px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); animation:fadeIn 1s forwards; }
input:focus { border:2px solid #007bff; box-shadow:0 0 8px rgba(0,123,255,0.3); outline:none; transition:0.3s; }
button { position:relative; overflow:hidden; transition:0.3s; }
button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
button:active::after { content:""; position:absolute; width:100%; height:100%; background:rgba(255,255,255,0.2); top:0; left:0; border-radius:inherit; animation:ripple 0.4s; }
.alert { opacity:0; animation:fadeIn 0.8s forwards; margin-bottom:10px; }
@keyframes fadeIn { to { opacity:1; } }
@keyframes ripple { from { transform:scale(0); opacity:1; } to { transform:scale(2); opacity:0; } }
</style>
</head>
<body>
<main class="container">
<h3 class="text-center mb-3">Enter OTP</h3>

<?php if(!empty($msg)): ?>
<div class="alert" style="padding:8px; background:#f8d7da; color:#721c24;">
<?php echo $msg; ?>
</div>
<?php endif; ?>

<form method="post" class="d-flex flex-column gap-2">
<input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
<button class="btn btn-primary">Verify</button>
</form>

<?php if($otp_expired): ?>
<p style="color:red; margin-top:10px;">❌ OTP expired! <a href="forgot.php">Send OTP Again</a></p>
<?php endif; ?>

</main>
</body>
</html>
