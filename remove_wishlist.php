<?php
session_start();
include '../db.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM wishlist WHERE id=$id");
header("Location: wishlist.php");
?>
