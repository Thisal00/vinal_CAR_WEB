<?php
require_once '../db.php';
$token = $_GET['token'] ?? '';
$msg = '';

$stmt = $mysqli->prepare("SELECT id FROM users WHERE reset_token=? AND token_expiry > NOW()");
$stmt->bind_param('s', $token);
$stmt->execute();
$res = $stmt->get_result();

$valid = $res->num_rows === 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password - Vinal Auto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="container" style="max-width:420px">
    <h2>🔐 Reset Password</h2>

    <?php if ($valid): ?>
      <form method="post" action="reset-process.php" class="card form">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input name="new_password" type="password" placeholder="New password" required>
        <button class="btn">Reset Password</button>
      </form>
    <?php else: ?>
      <div class="alert">Invalid or expired token.</div>
    <?php endif; ?>
  </main>
</body>
</html>