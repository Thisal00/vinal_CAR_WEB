<?php require_once __DIR__.'/../db.php'; require_login(); ?>
<?php
  $msg='';
  if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_user'])) {
    if (($_SESSION['role'] ?? '') !== 'admin') {
      $msg = 'Only admin can add users.';
    } else {
      $u = trim($_POST['username'] ?? '');
      $p = $_POST['password'] ?? '';
      $role = $_POST['role'] ?? 'staff';
      if ($u && $p) {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (username,password_hash,role) VALUES (?,?,?)");
        $stmt->bind_param('sss',$u,$hash,$role);
        $stmt->execute(); $stmt->close();
        $msg = 'User added.';
      } else { $msg = 'Enter username and password.'; }
    }
  }
  if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['change_pass'])) {
    $p1 = $_POST['new_password'] ?? '';
    if ($p1) {
      $hash = password_hash($p1, PASSWORD_DEFAULT);
      $stmt = $mysqli->prepare("UPDATE users SET password_hash=? WHERE id=?");
      $stmt->bind_param('si',$hash,$_SESSION['user_id']);
      $stmt->execute(); $stmt->close();
      $msg = 'Password updated.';
    } else { $msg = 'Enter a new password.'; }
  }
  if (isset($_GET['delete'])) {
    if (($_SESSION['role'] ?? '') !== 'admin') { $msg = 'Only admin can delete users.'; }
    else {
      $id=(int)$_GET['delete'];
      if ($id === (int)($_SESSION['user_id'])) { $msg = 'You cannot delete yourself.'; }
      else {
        $stmt = $mysqli->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
        header('Location: users.php'); exit;
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <header style="display:flex;justify-content:space-between;align-items:center">
      <h2>Manage Users</h2>
      <div><a class="btn" href="dashboard.php">Dashboard</a> <a class="btn" href="logout.php">Logout</a></div>
    </header>
    <?php if ($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>

    <section class="grid">
      <div class="card p-2">
        <h3>Add User</h3>
        <form method="post" class="form">
          <input name="username" placeholder="Username" required>
          <input name="password" type="password" placeholder="Password" required>
          <select name="role">
            <option value="staff">staff</option>
            <option value="admin">admin</option>
          </select>
          <input type="hidden" name="add_user" value="1">
          <button class="btn">Add</button>
        </form>
      </div>
      <div class="card p-2">
        <h3>Change My Password</h3>
        <form method="post" class="form">
          <input name="new_password" type="password" placeholder="New password" required>
          <input type="hidden" name="change_pass" value="1">
          <button class="btn">Update</button>
        </form>
      </div>
    </section>

    <h3>All Users</h3>
    <table>
      <thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr></thead>
      <tbody>
      <?php
        $res = $mysqli->query("SELECT id, username, role FROM users ORDER BY id DESC");
        while ($u = $res->fetch_assoc()) {
          echo '<tr>';
          echo '<td>'.(int)$u['id'].'</td>';
          echo '<td>'.e($u['username']).'</td>';
          echo '<td>'.e($u['role']).'</td>';
          echo '<td class="actions">';
          if (($_SESSION['role'] ?? '')==='admin' && (int)$u['id'] !== (int)$_SESSION['user_id']) {
            echo '<a href="users.php?delete='.(int)$u['id'].'" onclick="return confirm(\'Delete user?\')">Delete</a>';
          } else {
            echo '-';
          }
          echo '</td>';
          echo '</tr>';
        }
      ?>
      </tbody>
    </table>
  </div>
</body></html>
