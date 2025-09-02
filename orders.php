<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT orders.*, parts.part_name, parts.image, parts.price 
        FROM orders 
        JOIN parts ON orders.part_id = parts.id 
        WHERE orders.user_id = $user_id 
        ORDER BY orders.ordered_at DESC";

$result = $conn->query($sql);

echo "<h2>My Orders</h2>";
echo "<table border='1'>";
echo "<tr><th>Image</th><th>Part</th><th>Qty</th><th>Status</th><th>Ordered At</th><th>Action</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><img src='uploads/" . $row['image'] . "' width='100'></td>";
    echo "<td>" . $row['part_name'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . $row['ordered_at'] . "</td>";
    if ($row['status'] == 'Pending') {
        echo "<td><a href='cancel_order.php?id=" . $row['id'] . "'>Cancel</a></td>";
    } else {
        echo "<td>-</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>