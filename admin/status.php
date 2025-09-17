<?php
session_start();
require_once __DIR__ . '/../db.php';

$booking_id = $_POST['booking_id'] ?? null;
$status = $_POST['status'] ?? null;
$email = $_POST['email'] ?? '';      // Customer email
$name = $_POST['name'] ?? '';
$vehicle = $_POST['vehicle'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';

if($booking_id && $status){
    // Update booking status in DB
    $stmt = $conn->prepare("UPDATE test_drive_bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();

    // If confirmed, send email to customer dynamically
    if($status === 'Confirmed' && $email){
        $message = "Hello $name,\n\nYour test drive booking is confirmed!\n\nVehicle: $vehicle\nDate: $date\nTime: $time\n\nThanks,\nVinal Auto Team";

        $formUrl = "https://formsubmit.co/$email"; // Customer email dynamically

        echo "<form id='emailForm' action='$formUrl' method='POST'>
                <input type='hidden' name='_subject' value='✅ Test Drive Booking Confirmed - Vinal Auto'>
                <input type='hidden' name='_replyto' value='no-reply@vinalauto.com'>
                <input type='hidden' name='message' value='".htmlspecialchars($message, ENT_QUOTES)."'>
              </form>
              <script>document.getElementById('emailForm').submit();</script>";
        exit;
    } else {
        header("Location: bookings.php?success=1");
        exit;
    }
}
?>
