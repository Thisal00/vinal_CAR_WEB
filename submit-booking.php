<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/db.php';

if (!isset($conn) || $conn->connect_error) {
  die("❌ Database connection failed: " . $conn->connect_error);
}

// Sanitize inputs
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
$vehicle_id = isset($_POST['vehicle_id']) ? intval($_POST['vehicle_id']) : 0;
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';

if (!$name || !$email || !$phone || !$vehicle_id || !$date || !$time) {
  die("❌ Missing required fields.");
}

if (!preg_match('/^07[0-9]{8}$/', $phone)) {
  die("❌ Invalid phone number format.");
}

$datetime = $date . ' ' . $time;

// Insert into DB
$stmt = $conn->prepare("
  INSERT INTO test_drive_bookings (name, email, phone, vehicle_id, time, status)
  VALUES (?, ?, ?, ?, ?, 'Pending')
");

if (!$stmt) {
  die("❌ Prepare failed: " . $conn->error);
}

// Bind parameters correctly
$stmt->bind_param("sssis", $name, $email, $phone, $vehicle_id, $datetime);

if ($stmt->execute()) {
  ?>
  <!-- ✅ Customer Confirmation Email -->
  <form id="customerMail" method="POST" action="https://formsubmit.co/<?= htmlspecialchars($email) ?>">
    <input type="hidden" name="_subject" value="📌 Test Drive Booking Received - Vinal Auto">
    <input type="hidden" name="message" value="Hello <?= htmlspecialchars($name) ?>,

Your test drive booking request has been received!

📍 Vehicle ID: <?= htmlspecialchars($vehicle_id) ?>
📅 Date: <?= htmlspecialchars($date) ?>
⏰ Time: <?= htmlspecialchars($time) ?>

We will confirm your booking shortly.

Thanks,
Vinal Auto Team">
  </form>

  <!-- ✅ Admin Notification Email -->
  <form id="adminMail" method="POST" action="https://formsubmit.co/thisalchathnuka@gmail.com">
    <input type="hidden" name="_subject" value="📢 New Test Drive Booking - Vinal Auto">
    <input type="hidden" name="message" value="New booking request received:

👤 Name: <?= htmlspecialchars($name) ?>
📧 Email: <?= htmlspecialchars($email) ?>
📞 Phone: <?= htmlspecialchars($phone) ?>
🚘 Vehicle ID: <?= htmlspecialchars($vehicle_id) ?>
📅 Date: <?= htmlspecialchars($date) ?>
⏰ Time: <?= htmlspecialchars($time) ?> 

Please log in to the admin panel to confirm.">
  </form>

  <script>
    // Send customer email first, then admin email
    document.getElementById("customerMail").submit();
    setTimeout(function() {
      document.getElementById("adminMail").submit();
    }, 2000); // 2-second gap to ensure both are sent
  </script>

  <!-- ✅ Thank You Message -->
  <div style="text-align:center; margin-top:50px;">
    <h2>🎉 Thank you, <?= htmlspecialchars($name) ?>!</h2>
    <p>Your test drive booking has been successfully submitted.</p>
    <p>We will confirm your booking shortly via email.</p>
    <a href="index.php" style="display:inline-block; margin-top:20px; padding:10px 20px; background:#0b1e3f; color:#fff; text-decoration:none; border-radius:5px;">🏠 Back to Home</a>
  </div>
  <?php
  exit;
} else {
  echo "❌ Execution error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
