<?php
include '../config/db.php';

$result = mysqli_query($conn, "
  SELECT b.*, v.title FROM test_drive_bookings b
  JOIN vehicles v ON b.vehicle_id = v.id
");

$events = [];

while ($row = mysqli_fetch_assoc($result)) {
  $events[] = [
    'title' => $row['name'] . ' - ' . $row['title'],
    'start' => $row['date'] . 'T' . $row['time'],
    'url' => '../admin/bookings.php'
  ];
}

echo json_encode($events);
?>