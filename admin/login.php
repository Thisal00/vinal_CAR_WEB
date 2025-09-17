<?php
session_start();
require_once __DIR__.'/../db.php';

// Initialize variables
$msg = '';
$hasUsers = false;

// Check if users exist
$res = $mysqli->query("SELECT COUNT(*) c FROM users");
if ($res) {
    $row = $res->fetch_assoc();
    $hasUsers = ((int)$row['c']) > 0;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    if ($u && $p) {
        $stmt = $mysqli->prepare("SELECT id, password_hash, role FROM users WHERE username=?");
        $stmt->bind_param('s', $u);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($p, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $u;
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit;
            }
        }
        $msg = 'Invalid credentials.';
    } else {
        $msg = 'Enter username and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - Vinal Auto</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
/* Fade-in animation for main container */
main.container {
    opacity: 0;
    animation: fadeIn 1s forwards;
}

/* Input focus animation */
form input:focus {
    border: 2px solid #007bff;
    box-shadow: 0 0 8px rgba(0,123,255,0.3);
    transition: 0.3s;
    outline: none;
}

/* Button hover effect */
form button.btn {
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}
form button.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Ripple effect on button click */
form button.btn:active::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.2);
    top: 0;
    left: 0;
    border-radius: inherit;
    animation: ripple 0.4s;
}

/* Alerts fade-in */
.alert {
    opacity: 0;
    animation: fadeIn 0.8s forwards;
}

/* Keyframes */
@keyframes fadeIn {
    to { opacity: 1; }
}
@keyframes ripple {
    from { transform: scale(0); opacity: 1; }
    to { transform: scale(2); opacity: 0; }
}
</style>
</head>
<body>
<main class="container" style="max-width:420px; margin:60px auto;">
<h2><?php echo $hasUsers ? 'Admin Login' : 'Create Admin'; ?></h2>

<?php if (!empty($msg)): ?>
<div class="alert" style="padding:8px; background:#f8d7da; color:#721c24; margin-bottom:10px;">
<?php echo $msg; ?>
</div>
<?php endif; ?>

<form method="post" class="card form" style="display:flex; flex-direction:column; gap:10px;">
<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>

<?php if ($hasUsers): ?>
<div style="margin-top:6px; text-align:right;">
<a href="forgot.php" style="font-size:0.9em; color:#007bff; text-decoration:none;">🔐 Forgot Password?</a>
</div>
<?php endif; ?>

<button class="btn"><?php echo $hasUsers ? 'Login' : 'Create Admin'; ?></button>
</form>
</main>
</body>
</html>
