<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

if ($_SESSION['role'] !== 'admin') {
  echo '<div style="padding:20px;color:red;">Access denied. Admins only.</div>';
  exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT m.*, p.name AS part_name FROM part_messages m LEFT JOIN vehicle_parts p ON m.part_id = p.id WHERE m.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
  echo '<div style="padding:20px;color:red;">Message not found.</div>';
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $reply = $_POST['reply'];
  $status = $_POST['status'];
  $stmt = $mysqli->prepare("UPDATE part_messages SET reply = ?, status = ? WHERE id = ?");
  $stmt->bind_param("ssi", $reply, $status, $id);
  $stmt->execute();
  $stmt->close();
  header("Location: messages.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reply to Part Request</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body { background: #0b1e3f; color: #fff; font-family: 'Poppins', sans-serif; }
    .container { max-width: 700px; margin: 40px auto; background: #11182e; padding: 20px; border-radius: 10px; }
    h2 { color: #ffd700; margin-bottom: 20px; }
    label { font-weight: bold; }
    .form-control { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #444; background: #1a233a; color: #fff; }
    .btn { background: #ffd700; color: #0b1e3f; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reply to Part Request</h2>
    <p><strong>Part:</strong> <?= htmlspecialchars($data['part_name']) ?></p>
    <p><strong>Customer:</strong> <?= htmlspecialchars($data['customer_name']) ?> (<?= htmlspecialchars($data['phone']) ?>)</p>
    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($data['message'])) ?></p>

    <form method="post">
      <label for="reply">Reply</label>
      <textarea name="reply" id="reply" class="form-control" required><?= htmlspecialchars($data['reply']) ?></textarea>

      <label for="status">Status</label>
      <select name="status" id="status" class="form-control">
        <option value="Pending" <?= $data['status']=='Pending'?'selected':'' ?>>Pending</option>
        <option value="Replied" <?= $data['status']=='Replied'?'selected':'' ?>>Replied</option>
        <option value="Handled" <?= $data['status']=='Handled'?'selected':'' ?>>Handled</option>
      </select>

      <button class="btn">Save Reply</button>
    </form>
  </div>
</body>
</html>