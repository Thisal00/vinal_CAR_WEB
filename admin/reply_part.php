<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

// Check admin role
if ($_SESSION['role'] !== 'admin') {
    exit('<div style="padding:20px;color:red;">Access denied. Admins only.</div>');
}

// Get message ID
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    exit('<div style="padding:20px;color:red;">Invalid message ID.</div>');
}

// Handle reply submission
$reply = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply = trim($_POST['reply']);
    if ($reply === '') {
        // Default polite message if empty
        $reply = "We are confirming your inquiry. Please visit our showroom to collect/order your vehicle part. Thank you for choosing Vinal Auto!";
    }

    $stmt = $mysqli->prepare("UPDATE part_messages SET reply = ?, status = 'replied' WHERE id = ?");
    $stmt->bind_param("si", $reply, $id);
    $stmt->execute();
    echo '<div style="padding:20px;color:green;">✅ Reply saved successfully!</div>';
}

// Fetch message details
$stmt = $mysqli->prepare("SELECT m.*, p.part_name AS part_name FROM part_messages m LEFT JOIN vehicle_parts p ON m.part_id = p.id WHERE m.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();
if (!$message) exit('<div style="padding:20px;color:red;">Message not found.</div>');

// Admin contact info
$adminWhatsApp = '+94768291088';
$adminEmail = 'thisalchathnuka@gmail.com';

// Message templates
$customerName = $message['customer_name'];
$partName = $message['part_name'] ?? 'Unknown';

$whatsappMsg = "Hello $customerName 👋\n\n$reply\n\nPart: $partName\nFrom Vinal Auto Admin: $adminWhatsApp";
$emailMsg = "Hello $customerName,\n\n$reply\n\nPart: $partName\nFrom Vinal Auto Admin: $adminEmail\n\nThank you for choosing Vinal Auto.";

// Links
$whatsappLink = 'https://wa.me/'.preg_replace('/[^0-9]/', '', $message['phone']).'?text='.urlencode($whatsappMsg);
$emailLink = 'mailto:'.$message['email'].'?subject='.urlencode('Vinal Auto Part Inquiry Confirmation').'&body='.urlencode($emailMsg);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reply to Part Message</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body { font-family: 'Poppins', sans-serif; background: #0b1e3f; color: #fff; }
.container { max-width: 800px; margin: 40px auto; padding: 25px; background: #11182e; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.5); }
h2 { color: #ffd700; margin-bottom: 25px; text-align:center; }
label { display: block; margin-top: 15px; font-weight: bold; }
textarea { width: 100%; height: 140px; padding: 12px; border-radius: 8px; border: none; margin-top: 8px; background: #1a2345; color:#fff; resize:none; }
.btn-submit { background: #00c853; color: #fff; padding: 12px 22px; border-radius: 8px; font-weight: bold; margin-top: 20px; display: inline-block; text-decoration: none; transition: 0.3s; cursor:pointer; }
.btn-submit:hover { background: #00e676; }
.btn-back { background: #ffd700; color: #0b1e3f; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 20px; transition: 0.3s; }
.btn-back:hover { background: #ffe033; }
.action-links a { margin-right: 10px; }
</style>
</head>
<body>
<div class="container">
<a href="messages.php" class="btn-back">← Back to Messages</a>
<h2>Reply to Part Message</h2>

<p><strong>Part:</strong> <?= htmlspecialchars($partName) ?></p>
<p><strong>Customer:</strong> <?= htmlspecialchars($customerName) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($message['phone']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($message['email'] ?? 'N/A') ?></p>
<p><strong>Message:</strong> <?= nl2br(htmlspecialchars($message['message'])) ?></p>

<form method="post" id="replyForm">
<label for="reply">Your Reply:</label>
<textarea name="reply" id="reply"><?= htmlspecialchars($message['reply'] ?? '') ?></textarea>
<button type="submit" class="btn-submit">💾 Save Reply & Send</button>
</form>

<div class="action-links" style="margin-top:25px;">
<a href="<?= $whatsappLink ?>" target="_blank" class="btn-submit" style="background:#25D366;">📱 Send via WhatsApp</a>
<a href="<?= $emailLink ?>" target="_blank" class="btn-submit" style="background:#4285F4;">✉️ Send via Email</a>
</div>
</div>

<script>
// Optional: auto-open WhatsApp after saving
document.getElementById('replyForm').addEventListener('submit', function(e){
    setTimeout(() => {
        window.open('<?= $whatsappLink ?>', '_blank'); // auto open WhatsApp
    }, 500);
});
</script>

</body>
</html>
