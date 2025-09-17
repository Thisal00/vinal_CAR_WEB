<?php
$conn = new mysqli("localhost", "root", "", "your_db");
$result = $conn->query("SELECT * FROM vehicle_list WHERE price BETWEEN 100000 AND 10000000");

echo "<h3>Vehicle Comparison</h3><table border='1'>
<tr><th>Model</th><th>Fuel</th><th>Price</th><th>Resale</th></tr>";
while($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['model_name']}</td>
    <td>{$row['fuel_efficiency']}</td>
    <td>Rs. {$row['price']}</td>
    <td>{$row['resale_value']}</td>
  </tr>";
}
echo "</table>";
?>