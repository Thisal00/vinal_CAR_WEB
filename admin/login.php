<?php require_once __DIR__.'/../db.php'; ?>
<?php
  // If user exists? If none, show Create Admin form
  $res = $mysqli->query("SELECT COUNT(*) c FROM users");
  $row = $res->fetch_assoc();
  $hasUsers = ((int)$row['c']) > 0;
  $msg = '';

  if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (!$hasUsers && isset($_POST['create_admin'])) {
      $u = trim($_POST['username'] ?? '');
      $p = $_POST['password'] ?? '';
      if ($u && $p) {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (username,password_hash,role) VALUES (?,?, 'admin')");
        $stmt->bind_param('ss',$u,$hash);
        $stmt->execute();
        $stmt->close();
        $msg = 'Admin created. Please log in.';
        $hasUsers = true;
      } else { $msg = 'Enter username and password.'; }
    } else {
      $u = trim($_POST['username'] ?? '');
      $p = $_POST['password'] ?? '';
      if ($u && $p) {
        $stmt = $mysqli->prepare("SELECT id,password_hash,role FROM users WHERE username=?");
        $stmt->bind_param('s',$u);
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
  }
?>
<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <main class="container" style="max-width:420px">
    <h2><?php echo $hasUsers ? 'Admin Login' : 'Create Admin'; ?></h2>
    <?php if ($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>
    <form method="post" class="card form">
      <input name="username" placeholder="Username" required>
      <input name="password" type="password" placeholder="Password" required>
      <?php if (!$hasUsers) echo '<input type="hidden" name="create_admin" value="1">'; ?>
      <button class="btn"><?php echo $hasUsers ? 'Login' : 'Create Admin'; ?></button>
    </form>
  </main>
</body></html>
