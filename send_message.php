<?php
require_once __DIR__.'/db.php';

$part_id = $_POST['part_id'];
$name = $_POST['customer_name'];
$phone = $_POST['phone'];
$msg = $_POST['message'];

$stmt = $mysqli->prepare("INSERT INTO messages (part_id, customer_name, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $part_id, $name, $phone, $msg);
$stmt->execute();
$stmt->close();

header("Location: parts.php?sent=1");
exit;