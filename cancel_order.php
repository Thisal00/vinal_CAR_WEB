<?php
session_start();
include '../db.php';
$id = intval($_GET['id']);
$conn->query("UPDATE orders SET status='Cancelled' WHERE order_id=$id");
header("Location: orders.php");
?>
