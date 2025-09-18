<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Correct path to db.php
include __DIR__ . '/../db.php';

if (!$conn) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE test_drive_bookings SET status=? WHERE id=?");
    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $booking_id);
    if ($stmt->execute()) {
        // Redirect back to admin panel
        header("Location: bookings.php?success=1");
        exit;
    } else {
        echo "❌ Execution error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

