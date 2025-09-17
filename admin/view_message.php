<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

if ($_SESSION['role'] !== 'admin') {
  exit('Access denied');
}

$id = (int)($_GET['id'] ?? 0);
$res = $mysqli->prepare("SELECT name, email, message, created_at FROM messages WHERE id = ?");
$res->bind_param("i", $id);
$res->execute();
$res->store_result();

if ($res->num_rows === 0) {
  echo "Message not found.";
  exit;
}

$res->bind_result($name, $email, $message, $created_at);
$res->fetch();
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Message</title>
  <meta charset="UTF-8">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #0b1e3f; color: #fff; padding: 40px; }
    .container { max-width: 800px; margin: auto; background: #11182e; padding: 20px; border-radius: 10px; }
    h2 { color: #ffd700; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    textarea, input { width: 100%; padding: 10px; margin-top: 5px; border-radius: 6px; border: none; }
    button { background: #ffd700; color: #0b1e3f; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; margin-top: 20px; cursor: pointer; }
    a.back { color: #ffd700; text-decoration: none; display: inline-block; margin-bottom: 20px; }
  </style>
</head>
<body>
  <div class="container">
    <a href="messages.php" class="back">← Back to Messages</a>
    <h2>📨 Message from <?php echo htmlspecialchars($name); ?></h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Sent At:</strong> <?php echo htmlspecialchars($created_at); ?></p>
    <p><strong>Message:</strong><br><?php echo nl2br(htmlspecialchars($message)); ?></p>

    <form method="post" action="send_reply.php">
      <input type="hidden" name="to_email" value="<?php echo htmlspecialchars($email); ?>">
      <label>Reply Message:</label>
      <textarea name="reply" rows="6" required></textarea>
      <button type="submit">Send Reply</button>
    </form>
  </div>
</body>
</html>