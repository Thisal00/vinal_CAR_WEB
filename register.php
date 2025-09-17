<?php
session_start();
include '../db.php';
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users(username,email,password) VALUES('$name','$email','$pass')");
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['username'] = $name;
    header("Location: parts.php");
}
?>
<form method="post">
<input name="name" placeholder="Name">
<input name="email" placeholder="Email">
<input type="password" name="password" placeholder="Password">
<button name="register">Register</button>
</form>
