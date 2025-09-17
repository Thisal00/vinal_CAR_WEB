<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $vehicle_id = $_POST['vehicle_id'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $status = "Confirmed"; // Admin-entered bookings are usually confirmed

  $stmt = $conn->prepare("
    INSERT INTO test_drive_bookings (name, phone, vehicle_id, date, time, status)
    VALUES (?, ?, ?, ?, ?, ?)
  ");

  $stmt->bind_param("ssisss", $name, $phone, $vehicle_id, $date, $time, $status);

  if ($stmt->execute()) {
    header("Location: bookings.php?success=1");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>