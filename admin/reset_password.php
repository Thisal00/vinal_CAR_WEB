<?php
session_start();
require_once "../db.php";

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['otp_verified'])) {
    $email = $_SESSION['reset_email'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("UPDATE users SET password_hash=?, reset_otp=NULL, otp_expires=NULL WHERE email=?");
    $stmt->bind_param("ss", $new_pass, $email);
    $stmt->execute();

    $msg = "✅ Password updated successfully! Redirecting to login page...";
    
    // Auto redirect after 3 seconds
    echo "<script>
            setTimeout(() => { window.location.href = 'login.php'; }, 3000);
          </script>";

    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - Vinal Auto</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
main.container { max-width:400px; margin:80px auto; padding:30px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); animation:fadeIn 1s forwards; }
input:focus { border:2px solid #007bff; box-shadow:0 0 8px rgba(0,123,255,0.3); outline:none; transition:0.3s; }
button { position:relative; overflow:hidden; transition:0.3s; }
button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
button:active::after { content:""; position:absolute; width:100%; height:100%; background:rgba(255,255,255,0.2); top:0; left:0; border-radius:inherit; animation:ripple 0.4s; }
.alert { opacity:0; animation:fadeIn 0.8s forwards; margin-bottom:10px; padding:8px; border-radius:5px; }
.alert-success { background:#d4edda; color:#155724; }
.alert-error { background:#f8d7da; color:#721c24; }
@keyframes fadeIn { to { opacity:1; } }
@keyframes ripple { from { transform:scale(0); opacity:1; } to { transform:scale(2); opacity:0; } }
</style>
</head>
<body>
<main class="container">
<h3 class="text-center mb-3">Reset Password</h3>

<?php if(!empty($msg)): ?>
<div class="alert alert-success">
    <?php echo $msg; ?>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['otp_verified'])): ?>
<form method="post" class="d-flex flex-column gap-2">
    <input type="password" name="new_pass" class="form-control" placeholder="New Password" required>
    <button class="btn btn-primary">Update Password</button>
</form>
<?php else: ?>
<div class="alert alert-error">
    ❌ Session expired or unauthorized access. <a href="forgot.php">Request OTP again</a>
</div>
<?php endif; ?>

</main>
</body>
</html>
