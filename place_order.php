<?php
session_start();
include '../db.php';
$user_id = $_SESSION['user_id'];
$part_id = $_POST['part_id'];
$qty = $_POST['quantity'];
$conn->query("INSERT INTO orders(user_id,part_id,quantity) VALUES($user_id,$part_id,$qty)");
header("Location: orders.php");
?>
