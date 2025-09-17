<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

// 🔐 Only allow admin access
if ($_SESSION['role'] !== 'admin') {
  echo '<div style="padding:20px;color:red;">Access denied. Admins only.</div>';
  exit;
}

// 🧾 Fetch message data
$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT m.*, p.name AS part_name FROM part_messages m LEFT JOIN vehicle_parts p ON m.part_id = p.id WHERE m.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
  echo '<div style="padding:20px;color:red;">Request not found.</div>';
  exit;
}

// ✅ Handle reply submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $phone  = trim($_POST['phone'] ?? '');
  $reply  = trim($_POST['reply'] ?? '');
  $status = $_POST['status'] ?? 'Pending';
  $email  = trim($_POST['email'] ?? '');

  if ($phone === '' || $reply === '') {
    $feedback = '<div style="padding:20px;color:red;">Phone or reply is missing.</div>';
  } else {
    // ✉️ Optional email reply
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $subject = "Reply to your part request";
      $headers = "From: vinalauto@example.com\r\n";
      $headers .= "Content-Type: text/plain; charset=UTF-8";
      mail($email, $subject, $reply, $headers);
    }

    // 💾 Save reply and status
    $stmt = $mysqli->prepare("UPDATE part_messages SET reply = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $reply, $status, $id);
    $stmt->execute();
    $stmt->close();

    // 📲 WhatsApp link
    $clean_phone = '94' . ltrim($phone, '0');
    $customer_name = htmlspecialchars($data['customer_name'] ?? 'Customer');
    $whatsapp_message = urlencode("Hello $customer_name, your part request has been replied:\n\n$reply");
    $whatsapp_link = "https://wa.me/$clean_phone?text=$whatsapp_message";

    // ✅ Feedback
    $feedback = '<div style="padding:20px;color:limegreen;">Reply saved for '. $customer_name .'</div>';
    $feedback .= '<div style="margin-top:10px;">
      <a href="'. $whatsapp_link .'" target="_blank" style="color:#25D366;font-weight:bold;">
        📲 Send via WhatsApp
      </a>
    </div>';
  }
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
    <?php if (isset($feedback)) echo $feedback; ?>

    <p><strong>Part:</strong> <?= htmlspecialchars($data['part_name'] ?? 'Unknown') ?> (ID: <?= (int)($data['part_id'] ?? 0) ?>)</p>
    <p><strong>Customer:</strong> <?= htmlspecialchars($data['customer_name'] ?? 'Unknown') ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($data['phone'] ?? 'Not provided') ?></p>
    <p><strong>Email:</strong>
      <?= isset($data['email']) && $data['email'] !== '' ? htmlspecialchars($data['email']) : '<em>Not provided</em>' ?>
    </p>
    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($data['message'] ?? '')) ?></p>

    <form method="post">
      <input type="hidden" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">

      <label for="reply">Reply</label>
      <textarea name="reply" id="reply" class="form-control" required><?= htmlspecialchars($data['reply'] ?? '') ?></textarea>

      <label for="status">Status</label>
      <select name="status" id="status" class="form-control">
        <option value="Pending" <?= ($data['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Replied" <?= ($data['status'] ?? '') === 'Replied' ? 'selected' : '' ?>>Replied</option>
        <option value="Handled" <?= ($data['status'] ?? '') === 'Handled' ? 'selected' : '' ?>>Handled</option>
      </select>

      <button class="btn">Send Reply</button>
    </form>
  </div>
</body>
</html>