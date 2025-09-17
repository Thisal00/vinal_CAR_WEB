<?php 
require_once __DIR__.'/../db.php'; 
require_login(); 
?>
<?php
$msg = '';

// Add user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    if (($_SESSION['role'] ?? '') !== 'admin') {
        $msg = 'Only admin can add users.';
    } else {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'staff';
        if ($u && $p) {
            $hash = password_hash($p, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users (username,password_hash,role) VALUES (?,?,?)");
            $stmt->bind_param('sss', $u, $hash, $role);
            $stmt->execute(); 
            $stmt->close();
            $msg = 'User added.';
        } else {
            $msg = 'Enter username and password.';
        }
    }
}

// Change own password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_pass'])) {
    $p1 = $_POST['new_password'] ?? '';
    if ($p1) {
        $hash = password_hash($p1, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE users SET password_hash=? WHERE id=?");
        $stmt->bind_param('si', $hash, $_SESSION['user_id']);
        $stmt->execute(); 
        $stmt->close();
        $msg = 'Password updated.';
    } else {
        $msg = 'Enter a new password.';
    }
}

// Admin reset any user's password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_change_pass'])) {
    if (($_SESSION['role'] ?? '') !== 'admin') {
        $msg = 'Only admin can change other users\' passwords.';
    } else {
        $uid = (int)($_POST['user_id'] ?? 0);
        $newPass = $_POST['admin_new_password'] ?? '';
        if ($uid && $newPass) {
            $hash = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("UPDATE users SET password_hash=? WHERE id=?");
            $stmt->bind_param('si', $hash, $uid);
            $stmt->execute(); 
            $stmt->close();
            $msg = 'Password updated for user ID '.$uid;
        } else {
            $msg = 'Enter user ID and new password.';
        }
    }
}

// Delete user
if (isset($_GET['delete'])) {
    if (($_SESSION['role'] ?? '') !== 'admin') {
        $msg = 'Only admin can delete users.';
    } else {
        $id = (int)$_GET['delete'];
        if ($id === (int)$_SESSION['user_id']) {
            $msg = 'You cannot delete yourself.';
        } else {
            $stmt = $mysqli->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
            header('Location: users.php'); 
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users - Vinal Auto</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
  /* Optional: highlight border by strength */
  input.weak { border-color: red; }
  input.medium { border-color: blue; }
  input.strong { border-color: orange; }
  input.very-strong { border-color: green; }
</style>
</head>
<body>
<div class="container">
  <header style="display:flex;justify-content:space-between;align-items:center">
    <h2>Manage Users</h2>
    <div>
      <a class="btn" href="dashboard.php">Dashboard</a> 
      <a class="btn" href="logout.php">Logout</a>
    </div>
  </header>

  <?php if ($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>

  <section class="grid">
    <!-- Add User -->
    <div class="card p-2">
      <h3>Add User</h3>
      <form method="post" class="form">
        <input name="username" placeholder="Username" required>
        <input id="add-password" name="password" type="password" placeholder="Password" required>
        <div style="margin-top:4px;">
          <button type="button" onclick="togglePassword('add-password')">👁 Show/Hide</button>
          <button type="button" onclick="generatePassword('add-password')">🔄 Generate</button>
        </div>
        <small id="add-password-strength"></small>
        <select name="role">
          <option value="staff">staff</option>
          <option value="admin">admin</option>
        </select>
        <input type="hidden" name="add_user" value="1">
        <button class="btn">Add</button>
      </form>
    </div>

    <!-- Change My Password -->
    <div class="card p-2">
      <h3>Change My Password</h3>
      <form method="post" class="form">
        <input id="my-password" name="new_password" type="password" placeholder="New password" required>
        <div style="margin-top:4px;">
          <button type="button" onclick="togglePassword('my-password')">👁 Show/Hide</button>
          <button type="button" onclick="generatePassword('my-password')">🔄 Generate</button>
        </div>
        <small id="my-password-strength"></small>
        <input type="hidden" name="change_pass" value="1">
        <button class="btn">Update</button>
      </form>
    </div>

    <!-- Admin Reset Password -->
    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
    <div class="card p-2">
      <h3>Reset User Password</h3>
      <form method="post" class="form">
        <input name="user_id" type="number" placeholder="User ID" required>
        <input id="admin-password" name="admin_new_password" type="password" placeholder="New password" required>
        <div style="margin-top:4px;">
          <button type="button" onclick="togglePassword('admin-password')">👁 Show/Hide</button>
          <button type="button" onclick="generatePassword('admin-password')">🔄 Generate</button>
        </div>
        <small id="admin-password-strength"></small>
        <input type="hidden" name="admin_change_pass" value="1">
        <button class="btn">Reset</button>
      </form>
    </div>
    <?php endif; ?>
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
        if (($_SESSION['role'] ?? '') === 'admin' && (int)$u['id'] !== (int)$_SESSION['user_id']) {
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

<!-- Password Tools Script -->
<script>
function togglePassword(fieldId) {
  const input = document.getElementById(fieldId);
  input.type = input.type === "password" ? "text" : "password";
}

function validatePassword(password) {
  const minLength = password.length >= 8;
  const hasLetter = /[A-Za-z]/.test(password);
  const hasNumber = /\d/.test(password);
  const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
  return { minLength, hasLetter, hasNumber, hasSpecial };
}

function checkStrength(fieldId, password) {
  const feedbackEl = document.getElementById(fieldId + '-strength');
  const inputEl = document.getElementById(fieldId);
  const { minLength, hasLetter, hasNumber, hasSpecial } = validatePassword(password);
  let strength = 0;
  if(minLength) strength++;
  if(hasLetter) strength++;
  if(hasNumber) strength++;
  if(hasSpecial) strength++;

  let text = '';
  let color = 'red';
  inputEl.classList.remove('weak','medium','strong','very-strong');

  switch(strength) {
    case 4: text='Very Strong'; color='green'; inputEl.classList.add('very-strong'); break;
    case 3: text='Strong'; color='orange'; inputEl.classList.add('strong'); break;
    case 2: text='Medium'; color='blue'; inputEl.classList.add('medium'); break;
    default: text='Weak'; color='red'; inputEl.classList.add('weak');
  }

  feedbackEl.textContent = text;
  feedbackEl.style.color = color;
}

function generatePassword(fieldId, length=12) {
  const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?";
  let password = "";
  for(let i=0;i<length;i++){
    password += chars.charAt(Math.floor(Math.random()*chars.length));
  }
  const input = document.getElementById(fieldId);
  input.value = password;
  checkStrength(fieldId, password);
}

// Real-time password strength check
['add-password','my-password','admin-password'].forEach(id=>{
  const input = document.getElementById(id);
  input.addEventListener('input', e=>checkStrength(id, e.target.value));
});
</script>
</body>
</html>
