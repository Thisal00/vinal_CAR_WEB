<?php
session_start();
require_once "../db.php";
require '../vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $otp = rand(100000, 999999);
        $expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $stmt2 = $mysqli->prepare("UPDATE users SET reset_otp=?, otp_expires=? WHERE email=?");
        $stmt2->bind_param("sss", $otp, $expires, $email);
        $stmt2->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thisalchathnuka80@gmail.com';
            $mail->Password = 'sdrybeducsspqsqd'; // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('thisalchathnuka80@gmail.com', 'Vinal Auto');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "🔐 Password Reset OTP";
            $mail->Body = "Your OTP is <b>$otp</b>. It expires in 5 minutes.";

            $mail->send();
            $_SESSION['reset_email'] = $email;
            header("Location: verify_otp.php");
            exit;
        } catch (Exception $e) {
            $msg = "Error sending OTP: {$mail->ErrorInfo}";
        }
    } else {
        $msg = "❌ Email not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - Vinal Auto</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
/* Fade-in main card */
main.container { opacity: 0; animation: fadeIn 1s forwards; }

/* Card styling */
.card { max-width:400px; margin:80px auto; padding:30px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }

/* Input focus */
.card input:focus { border: 2px solid #007bff; box-shadow: 0 0 8px rgba(0,123,255,0.3); outline:none; transition:0.3s; }

/* Button hover */
.card button { position:relative; overflow:hidden; transition:0.3s; }
.card button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.15); }

/* Ripple effect */
.card button:active::after { content:""; position:absolute; width:100%; height:100%; background:rgba(255,255,255,0.2); top:0; left:0; border-radius:inherit; animation:ripple 0.4s; }

/* Alerts fade-in */
.alert { opacity:0; animation:fadeIn 0.8s forwards; }

/* Keyframes */
@keyframes fadeIn { to { opacity:1; } }
@keyframes ripple { from { transform:scale(0); opacity:1; } to { transform:scale(2); opacity:0; } }
</style>
</head>
<body>
<main class="container">
<div class="card">
<h3 class="text-center mb-4">Forgot Password</h3>

<?php if(!empty($msg)): ?>
<div class="alert" style="padding:8px; background:#f8d7da; color:#721c24; margin-bottom:10px;">
<?php echo $msg; ?>
</div>
<?php endif; ?>

<form method="post" class="d-flex flex-column gap-3">
<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
<button class="btn btn-primary">Send OTP</button>
</form>
</div>
</main>
</body>
</html>
