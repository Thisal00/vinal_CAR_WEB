<?php
session_start();
include '../db.php';
$user_id = $_SESSION['user_id'];
$part_id = $_POST['part_id'];
$conn->query("INSERT INTO wishlist(user_id,part_id) VALUES($user_id,$part_id)");
header("Location: wishlist.php");
?>
