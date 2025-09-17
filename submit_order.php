<?php
include 'db.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$part_id = $_POST['part_id'];
$order_code = strtoupper(substr(md5(time()), 0, 6));

// Save to orders table
$sql = "INSERT INTO orders (customer_name, customer_email, phone, part_id, order_code)
        VALUES ('$name', '$email', '$phone', '$part_id', '$order_code')";
mysqli_query($conn, $sql);

// Create Sinhala message
$msg = "නව order එකක් ලැබී ඇත. කේතය: $order_code. ගනුදෙනුකරු: $name ($phone)";

// Save to admin messages panel
mysqli_query($conn, "INSERT INTO part_messages (part_id, customer_name, phone, message, status)
                     VALUES ('$part_id', '$name', '$phone', '$msg', 'unread')");

// ✅ Show success message to user (stay on same page)
echo "<p style='color:green;'>ඔබගේ order එක සාර්ථකව ලැබී ඇත. කේතය: <strong>$order_code</strong></p>";
?>